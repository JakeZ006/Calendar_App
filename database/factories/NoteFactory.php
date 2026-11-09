<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
#[UseModel(Note::class)]
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->name(),
            'title' => fake()->title(),
            'type' => fake()->randomElement(['todo', 'birthday', 'holiday', 'event', 'misc']),
            'important' => fake()->boolean(),
            'expirable' => fake()->boolean(),
            'for_date' => fake()->date(),
            'content' => fake()->paragraph(),
        ];
    }
}
