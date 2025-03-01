<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    // Create a new attribute
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:text,date,number,select',
        ]);

        $attribute = Attribute::create($request->all());

        return response()->json($attribute, 201);
    }

    // Update an existing attribute
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:text,date,number,select',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->update($request->all());

        return response()->json($attribute);
    }

    // Show an attribute by ID
    public function show($id)
    {
        $attribute = Attribute::findOrFail($id);
        return response()->json($attribute);
    }
}