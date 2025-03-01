<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    // Define the inverse relationship with users (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the inverse relationship with projects (belongsTo)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
