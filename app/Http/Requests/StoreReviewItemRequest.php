<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewItemRequest extends FormRequest
{
    /**
     * Learners only ever add to their own notebook; the route requires a login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The question snapshot sent from the page. It is only ever shown back to the same
     * learner as text, so the caps here are about keeping the row small and sane.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:80'],
            'mission' => ['required', 'string', 'max:64'],
            'missionTitle' => ['required', 'string', 'max:120'],
            'prompt' => ['required', 'string', 'max:600'],
            'code' => ['nullable', 'string', 'max:2000'],
            'explanation' => ['nullable', 'string', 'max:1600'],
            'options' => ['required', 'array', 'min:2', 'max:6'],
            'options.*.text' => ['required', 'string', 'max:300'],
            'options.*.correct' => ['required', 'boolean'],
        ];
    }
}
