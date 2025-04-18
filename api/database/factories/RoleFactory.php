<?php

namespace Database\Factories;


use App\Models\Usuario\Role;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'slug' => substr($this->faker->unique()->slug(), 0, 60),
            'label' => $this->faker->jobTitle(),
            'is_active' => true,
        ];
    }
}
