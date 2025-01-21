<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiaryRequest;
use App\Http\Requests\UpdateDiaryRequest;
use App\Models\Diary;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
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

        return view('diaries.index', [
            'diaries' => $user->diaries()
                ->orderByDesc('created_at')
                ->paginate(5)
                ->through(fn (Diary $diary) => [
                    'title' => $diary->created_at?->format('Y年m月d日'),
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiaryRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diary $diary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiaryRequest $request, Diary $diary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diary $diary)
    {
        //
    }
}
