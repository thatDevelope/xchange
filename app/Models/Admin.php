<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    // Fields allowed for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hidden fields (e.g., don't return password or token in JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
