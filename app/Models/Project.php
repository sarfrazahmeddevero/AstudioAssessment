<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Define the polymorphic relationship with AttributeValue
    public function attributeValues()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }
}
