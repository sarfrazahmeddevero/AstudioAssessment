<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); // Ensure that authentication is applied to all methods
    }

    public function index(Request $request)
    {
        $query = Project::query();
    
        // Handle regular attribute filtering (e.g., name, status)
        if ($request->has('filters')) {
            foreach ($request->get('filters') as $attributeName => $value) {
                if (in_array($attributeName, ['name', 'status'])) {
                    // For regular attributes, filter directly on the Project model
                    $query->where($attributeName, 'LIKE', '%' . $value . '%');
                } else {
                    // Handle EAV attributes
                    $attribute = Attribute::where('name', $attributeName)->first();
    
                    if ($attribute) {
                        $query->whereHas('attributeValues', function ($query) use ($attribute, $value) {
                            $query->where('attribute_id', $attribute->id)
                                ->where('value', 'LIKE', '%' . $value . '%');
                        });
                    }
                }
            }
        }
    
        // Apply additional filtering for numeric and date operators (e.g., >, <, =)
        if ($request->has('filters_operators')) {
            foreach ($request->get('filters_operators') as $attributeName => $operator) {
                $value = $request->get('filters')[$attributeName] ?? null;
    
                if (in_array($attributeName, ['name', 'status'])) {
                    $query->where($attributeName, $operator, $value);
                } else {
                    $attribute = Attribute::where('name', $attributeName)->first();
                    if ($attribute) {
                        $query->whereHas('attributeValues', function ($query) use ($attribute, $value, $operator) {
                            $query->where('attribute_id', $attribute->id)
                                ->where('value', $operator, $value);
                        });
                    }
                }
            }
        }
    
        $projects = $query->get();
        return response()->json($projects);
    }
    
    
    public function show($id)
    {
        $project = Project::with('attributeValues.attribute')->findOrFail($id);
        return response()->json($project);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'nullable|string',
            'attributes' => 'array',
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        $project = Project::create($validated);

        // Set dynamic attribute values for the project
        foreach ($validated['attributes'] as $attributeData) {
            AttributeValue::create([
                'attribute_id' => $attributeData['attribute_id'],
                'entity_id' => $project->id,
                'entity_type' => Project::class,
                'value' => $attributeData['value'],
            ]);
        }

        return response()->json($project, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'nullable|string',
            'attributes' => 'array',
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required|string',
        ]);

        $project = Project::findOrFail($id);
        $project->update($validated);

        // Update or create dynamic attribute values for the project
        foreach ($validated['attributes'] as $attributeData) {
            $attributeValue = AttributeValue::where('entity_id', $project->id)
                                            ->where('attribute_id', $attributeData['attribute_id'])
                                            ->first();
            
            if ($attributeValue) {
                $attributeValue->update(['value' => $attributeData['value']]);
            } else {
                // If the attribute value doesn't exist, create it
                AttributeValue::create([
                    'attribute_id' => $attributeData['attribute_id'],
                    'entity_id' => $project->id,
                    'entity_type' => Project::class,
                    'value' => $attributeData['value'],
                ]);
            }
        }

        return response()->json($project, 200);
    }
}
