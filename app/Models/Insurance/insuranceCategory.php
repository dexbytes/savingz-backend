<?php

namespace App\Models\Insurance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class insuranceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'status',
    ];
}
