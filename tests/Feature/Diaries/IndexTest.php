<?php

use App\Models\Diary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('shows appropriate message when no diaries found', function () {
    $user = User::factory()->createOne();

    actingAs($user)->get(route('diaries.index'))
        ->assertSee('日記が追加されていません。');
});

test('shows diary when available', function () {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne();

    actingAs($user)->get(route('diaries.index'))
        ->assertSee($diary->content);
});
