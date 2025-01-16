<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('can see login page as guest', function () {
    get(route('login'))->assertOk();
});

test('cannot see login page if logged in', function () {
    $user = User::factory()->createOne();
    actingAs($user)->get(route('login'))
      ->assertRedirectToRoute('home');
});
