<?php

namespace App\Http\Requests;

use App\Enums\EndpointFrequency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEndpointRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('storeEndpoint', $this->site);
    }

    public function rules(): array
    {
        return [
            'location' => ['required', 'string'],
            'frequency' => ['required', new Enum(EndpointFrequency::class)],
        ];
    }
}
