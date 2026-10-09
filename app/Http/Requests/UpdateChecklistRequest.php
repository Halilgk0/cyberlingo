<?php

namespace App\Http\Requests;

use App\Enums\ChecklistItem;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChecklistRequest extends FormRequest
{
    /**
     * Learners only ever tick their own checklist; the route requires a login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * An unticked form sends no `items` at all, which clears the checklist.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['sometimes', 'array'],
            'items.*' => ['distinct', Rule::enum(ChecklistItem::class)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'items' => 'maddeler',
            'items.*' => 'madde',
        ];
    }
}
