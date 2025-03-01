<?php

// app/Models/AttributeValue.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'entity_id', 'entity_type', 'value'];  // Fillable fields

    // Define the polymorphic relationship to the associated entity (e.g., Project)
    public function entity()
    {
        return $this->morphTo();
    }

    // Define the relationship to Attribute (Many-to-One)
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
