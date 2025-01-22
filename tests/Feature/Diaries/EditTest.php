<?php

use App\Models\Diary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertNotNull;

uses(RefreshDatabase::class);

test('shows diary content on edit page', function () {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne();
    assertNotNull($diary->created_at);
    
    actingAs($user)->get(route('diaries.edit', ['diary' => $diary]))
      ->assertSee($diary->created_at->format('Y-m-d'))
      ->assertSee($diary->content);
});
