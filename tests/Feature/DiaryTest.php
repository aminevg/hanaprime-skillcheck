<?php

use App\Models\Diary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertModelMissing;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake();
});

test('redirects to diaries page when visiting root', function () {
    $user = User::factory()->createOne();

    actingAs($user)->get('/')
        ->assertRedirectToRoute('diaries.index');
});

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

it('creates new diary', function (array $data) {
    $user = User::factory()->createOne();

    actingAs($user)->post(route('diaries.store'), $data)
        ->assertValid()
        ->assertRedirectToRoute('diaries.index')
        ->assertSessionHas('status', 'diary-created');

    $new_diary = $user->diaries()->first();
    assertNotNull($new_diary);
    assertEquals($data['diary_date'], $new_diary->diary_date->format('Y-m-d'));
    assertEquals($data['content'], $new_diary->content);

    if (isset($data['image'])) {
        assertNotNull($new_diary->file_name);
        Storage::assertCount('/', 1);
    } else {
        Storage::assertCount('/', 0);
    }
})->with([
    'no image' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
    ]],
    'with image' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
        'image' => UploadedFile::fake()->create('image.png', 512, 'image/png'),
    ]],
]);

it('throws error if new diary is invalid', function (array $data) {
    $user = User::factory()->createOne();

    actingAs($user)->post(route('diaries.store'), $data)
        ->assertInvalid();

    assertDatabaseEmpty('diaries');
})->with([
    'no date' => [[
        'content' => 'This is a great day to start a new challenge',
    ]],
    'no content' => [[
        'diary_date' => '2025-01-01',
    ]],
    'content is too long' => [[
        'diary_date' => '2025-01-01',
        'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.',
    ]],
    'image is not an image' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
        'image' => UploadedFile::fake()->create('image.png', 512, 'application/powerpoint'),
    ]],
    'image is too big' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
        'image' => UploadedFile::fake()->create('image.png', 1025, 'image/png'),
    ]],
]);

it('throws error if new diary is in the future', function () {
    $user = User::factory()->createOne();

    actingAs($user)->post(route('diaries.store'), [
        'diary_date' => today()->addDay()->format('Y-m-d'),
        'content' => 'This is a great day to start a new challenge',
    ])
        ->assertInvalid(['diary_date']);

    assertDatabaseEmpty('diaries');
});

it('throws error if new diary has same date as existing diary', function () {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne();

    actingAs($user)->post(route('diaries.store'), [
        'diary_date' => $diary->diary_date->format('Y-m-d'),
        'content' => 'This is a great day to start a new challenge',
    ])
        ->assertInvalid(['diary_date']);

    assertDatabaseCount('diaries', 1);
});

it('updates diary', function (array $data) {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne(['diary_date' => '1970-01-01', 'content' => 'This is pretty old']);

    actingAs($user)
        ->patch(route('diaries.update', ['diary' => $diary]), $data)
        ->assertValid()
        ->assertRedirectToRoute('diaries.index')
        ->assertSessionHas('status', 'diary-updated');

    assertDatabaseCount('diaries', 1);

    $diary->refresh();
    assertEquals($data['diary_date'], $diary->diary_date->format('Y-m-d'));
    assertEquals($data['content'], $diary->content);

    assertNotNull($diary->file_name);
    Storage::assertCount('/', 1);
})->with([
    'no image' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
    ]],
    'with image' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
        'image' => UploadedFile::fake()->create('image.png', 512, 'image/png'),
    ]],
    'same date' => [[
        'diary_date' => '1970-01-01',
        'content' => 'This is a great day to start a new challenge',
    ]],
]);

it('throws error if updated diary is invalid', function (array $data) {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne(['diary_date' => '1970-01-01', 'content' => 'This is pretty old']);

    actingAs($user)
        ->patch(route('diaries.update', ['diary' => $diary]), $data)
        ->assertInvalid();
})->with([
    'no date' => [[
        'content' => 'This is a great day to start a new challenge',
    ]],
    'no content' => [[
        'diary_date' => '2025-01-01',
    ]],
    'content is too long' => [[
        'diary_date' => '2025-01-01',
        'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.',
    ]],
    'image is not an image' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
        'image' => UploadedFile::fake()->create('image.png', 512, 'application/powerpoint'),
    ]],
    'image is too big' => [[
        'diary_date' => '2025-01-01',
        'content' => 'This is a great day to start a new challenge',
        'image' => UploadedFile::fake()->create('image.png', 1025, 'image/png'),
    ]],
]);

it('throws error if updated diary is in the future', function () {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne(['diary_date' => '1970-01-01', 'content' => 'This is pretty old']);

    actingAs($user)
        ->patch(route('diaries.update', ['diary' => $diary]), [
            'diary_date' => today()->addDay()->format('Y-m-d'),
            'content' => 'This is a great day to start a new challenge',
        ])
        ->assertInvalid(['diary_date']);
});

it('throws error if updated diary has same date as existing other diary', function () {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne();
    $other_diary = Diary::factory()
        ->for($user)
        ->createOne();

    actingAs($user)
        ->patch(route('diaries.update', ['diary' => $diary]), [
            'diary_date' => $other_diary->diary_date->format('Y-m-d'),
            'content' => 'This is a great day to start a new challenge',
        ])
        ->assertInvalid(['diary_date']);
});

it('removes diary', function () {
    $user = User::factory()->createOne();
    $diary = Diary::factory()
        ->for($user)
        ->createOne();

    actingAs($user)
        ->delete(route('diaries.destroy', ['diary' => $diary]))
        ->assertRedirectToRoute('diaries.index')
        ->assertSessionHas('status', 'diary-deleted');

    assertModelMissing($diary);
});
