<?php

namespace Database\Seeders;
use App\Models\Recipe;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    
        // Créez un utilisateur
        $user = User::factory()->create();

        // Créez des recettes associées à cet utilisateur
        Recipe::factory(50)->create(['user_id' => $user->id]);
    
        \App\Models\Recipe::factory(10)->create();
        \App\Models\Ingredient::factory(50)->create();
        \App\Models\User::factory()->count(10)->create();




    }
}
