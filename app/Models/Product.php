<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'code',
        'name',
        'quantity',
        'price',
        'due_date',
        'entry_date',
        'picture'
    ];
}
