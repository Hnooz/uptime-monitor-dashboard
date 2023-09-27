<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'domain' => ['required', 'url'],
            'scheme' => ['required'],
            'description' => ['required'],
            'user_id' => ['required'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $parsed = parse_url($this['domain']);

        $this->merge([
            'scheme' => Arr::get($parsed, 'scheme'),
        ]);
    }

    protected function passedValidation(): void
    {
        $parsed = parse_url($this['domain']);

        $this->replace([
            'domain' => Arr::get($parsed, 'host'),
        ]);
    }
}
