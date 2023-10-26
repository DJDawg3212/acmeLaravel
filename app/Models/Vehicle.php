<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'num_serie',
        'color',
        'brand',
        'type',
    ];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    public function conductors() {
        return $this->belongsToMany(Conductor::class);
    }
}
