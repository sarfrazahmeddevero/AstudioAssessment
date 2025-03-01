<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        // Create a few attributes
        $attribute1 = Attribute::create([
            'name' => 'department',
            'type' => 'text',
        ]);

        $attribute2 = Attribute::create([
            'name' => 'start_date',
            'type' => 'date',
        ]);

        // Create a project
        $project = Project::create([
            'name' => 'Project A',
            'status' => 'Active',
        ]);

        // Attach attribute values to the project
        AttributeValue::create([
            'attribute_id' => $attribute1->id,
            'entity_id' => $project->id,
            'entity_type' => Project::class,
            'value' => 'IT',
        ]);

        AttributeValue::create([
            'attribute_id' => $attribute2->id,
            'entity_id' => $project->id,
            'entity_type' => Project::class,
            'value' => '2023-01-01',
        ]);
    }
}
