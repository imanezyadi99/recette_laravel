<?php

namespace App\Models;
use App\Models\User;
use App\Models\Ingredient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name','user_id', 'ingredients', 'instructions', 'preparation_time', 'photo'];


    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
