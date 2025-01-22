<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiaryRequest;
use App\Http\Requests\UpdateDiaryRequest;
use App\Models\Diary;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        /** @var User */
        $user = request()->user() ?? throw new Exception;

        if ($user->cannot('viewAny', Diary::class)) {
            abort(403);
        }

        return view('diaries.index', [
            'diaries' => $user->diaries()
                ->orderByDesc('created_at')
                ->paginate(5)
                ->through(fn (Diary $diary) => [
                    'id' => $diary->id,
                    'title' => $diary->diary_date->format('Y年m月d日'),
                    'image_path' => $diary->file_name
                        ? Storage::temporaryUrl(
                            $diary->file_name,
                            now()->addMinutes(5),
                        ) : null,
                    'content' => $diary->content,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (request()->user()?->cannot('create', Diary::class)) {
            abort(403);
        }

        return view('diaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiaryRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            // @phpstan-ignore method.nonObject
            $file_name = $request->file('image')?->store();

            request()->user()?->diaries()->create([
                'diary_date' => $request->date('diary_date'),
                'content' => $request->string('content'),
                'file_name' => $file_name,
            ]);
        });

        return to_route('diaries.index')->with([
            'status' => 'diary-created',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diary $diary): View
    {
        if (request()->user()?->cannot('update', $diary)) {
            abort(403);
        }

        return view('diaries.edit', [
            'diary' => $diary,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiaryRequest $request, Diary $diary): RedirectResponse
    {
        DB::transaction(function () use ($request, $diary) {
            $old_file_name = $diary->file_name;

            // @phpstan-ignore method.nonObject
            $new_file_name = $request->file('image')?->store();

            $diary->update([
                'diary_date' => $request->date('diary_date'),
                'content' => $request->string('content'),
                'file_name' => $new_file_name ?? $old_file_name,
            ]);

            // Remove old image ONLY if new image is uploaded
            if ($new_file_name && $old_file_name && ! Storage::delete($old_file_name)) {
                abort(500);
            }
        });

        return to_route('diaries.index')->with([
            'status' => 'diary-updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diary $diary)
    {
        if (request()->user()?->cannot('delete', $diary)) {
            abort(403);
        }
    }
}
