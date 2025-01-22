<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diary extends Model
{
    /** @use HasFactory<\Database\Factories\DiaryFactory> */
    use HasFactory, HasTimestamps;

    /**
     * Get the attributes that should be cast.
     *
     * @return array{diary_date: 'date'}
     */
    protected function casts(): array
    {
        return [
            'diary_date' => 'date',
        ];
    }

    /** @return BelongsTo<User,$this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
