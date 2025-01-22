<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diary>
 */
class DiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'diary_date' => fake()->unique()->date(),
            'content' => fake()->sentence(),
            'file_name' => $this->downloadPlaceholderFile(),
        ];
    }

    private function downloadPlaceholderFile(): ?string
    {
        $response = Http::get('https://fakeimg.pl/320x240');

        if (! $response->successful()) {
            return null;
        }

        $body = $response->body();

        $file_name = Str::random(40);

        if (! Storage::put($file_name, $body)) {
            return null;
        }

        return $file_name;
    }
}
