<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('can see login page as guest', function () {
    get(route('login.create'))->assertOk();
});

test('cannot see login page if logged in', function () {
    $user = User::factory()->createOne();
    actingAs($user)->get(route('login.create'))
        ->assertRedirectToRoute('diaries.index');
});

test('cannot see home page as guest', function () {
    get(route('diaries.index'))->assertRedirectToRoute('login.create');
});

test('can see home page if logged in', function () {
    $user = User::factory()->createOne();
    actingAs($user)->get(route('diaries.index'))
        ->assertOk();
});

test('can log in', function () {
    $user = User::factory()->createOne([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => 'password',
    ])->assertRedirectToRoute('diaries.index');

    assertAuthenticatedAs($user);
});

test('cannot log in with invalid email', function () {
    User::factory()->createOne([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    post(route('login.store'), [
        'email' => 'wrong-email@example.com',
        'password' => 'password',
    ])->assertInvalid(['email']);

    assertGuest();
});

test('cannot log in with invalid password', function () {
    User::factory()->createOne([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ])->assertInvalid(['email']);

    assertGuest();
});

test('can log out', function () {
    $user = User::factory()->createOne();

    actingAs($user)->delete(route('login.destroy'))
        ->assertRedirectToRoute('login.create');

    assertGuest();
});
