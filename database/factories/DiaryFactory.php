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
        $date = fake()->unique()->date();
        return [
            'content' => fake()->sentence(),
            'file_name' => $this->downloadPlaceholderFile(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    private function downloadPlaceholderFile(): ?string
    {
        $response = Http::get('https://fakeimg.pl/320x240');

        if (! $response->successful()) {
            return null;
        }

        if (! ($uri = $response->effectiveUri()?->getPath())) {
            return null;
        }

        $extension = Str::of($uri)->explode('.')->last();

        $body = $response->body();

        $file_name = Str::random(40).'.'.$extension;

        if (! Storage::put($file_name, $body)) {
            return null;
        }

        return $file_name;
    }
}
