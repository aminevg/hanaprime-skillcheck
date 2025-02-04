<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateDiaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->diary) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'diary_date' => [
                'required',
                'date',
                'before_or_equal:today',
                function (string $attribute, mixed $value, Closure $fail) {
                    $existing_diary = $this->user()
                        ?->diaries()
                        // @phpstan-ignore argument.type
                        ->whereDate('diary_date', $value)
                        ->first();
                    // @phpstan-ignore argument.type
                    if ($existing_diary && $existing_diary->isNot($this->diary)) {
                        $fail('同じ日付の日記が既に存在しています。');
                    }
                },
            ],
            'content' => [
                'required',
                'string',
                'max:255',
            ],
            'image' => [
                'nullable',
                File::image()->max(1024),
            ],
        ];
    }

    /** @return array<string,string> */
    public function attributes(): array
    {
        return [
            'diary_date' => '日付',
            'content' => '日記',
            'image' => '画像',
        ];
    }

    /** @return array<string,string> */
    public function messages(): array
    {
        return [
            'image.max' => '画像には、1 MB以下のファイルを指定してください。',
        ];
    }
}
