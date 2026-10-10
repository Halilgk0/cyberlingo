<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResolveReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Which review keys the learner just got right (to drop) and wrong (to reschedule).
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'correct' => ['array'],
            'correct.*' => ['string', 'max:80'],
            'wrong' => ['array'],
            'wrong.*' => ['string', 'max:80'],
        ];
    }
}
