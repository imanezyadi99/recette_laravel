<?php

namespace App\Models;
use App\Models\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function recipe()
    {
    return $this->belongsTo(Recipe::class);
    }
}
