<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;  // Import the trait


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // Define relationship with projects (Many-to-Many)
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    // Define relationship with timesheets (One-to-Many)
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}