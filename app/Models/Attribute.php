<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];  // Fillable fields for mass assignment

    // Define the relationship to AttributeValue (One-to-Many)
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}