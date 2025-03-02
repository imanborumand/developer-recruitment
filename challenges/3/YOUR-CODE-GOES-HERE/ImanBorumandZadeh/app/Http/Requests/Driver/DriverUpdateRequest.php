<?php

namespace App\Http\Requests\Driver;

use App\Enums\DriverStatus;
use App\Models\Driver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DriverUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return (
            Driver::isDriver($this->user()) &&
            Auth::user()->can('update',  Driver::byUser($this->user()))
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required_with:longitude', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['required_with:latitude', 'numeric', 'min:-180', 'max:180'],
            'status' => ['required', Rule::enum(DriverStatus::class)],
        ];
    }
}
