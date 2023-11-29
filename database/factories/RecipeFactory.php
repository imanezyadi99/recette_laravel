<?php

// database/factories/RecipeFactory.php

namespace Database\Factories;
use App\Models\Recipe;
use App\Models\User;



use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
protected $model=Recipe::class;

public function definition()
{
    $user = User::inRandomOrder()->first();

    return [
        'user_id' => $user->id,
        'name' => $this->faker->sentence,
        'ingredients' => $this->faker->paragraph,
        'instructions' => $this->faker->text,
        'preparation_time' => $this->faker->numberBetween(10, 120),
        'photo' => $this->faker->imageUrl(),
    ];
}
}
