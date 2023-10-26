<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_doc',
        'type_doc',
        'name',
        'other_name',
        'last_name',
        'phone',
        'email',
        'address',
        'city',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
