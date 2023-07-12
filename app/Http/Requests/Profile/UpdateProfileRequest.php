<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                'unique:users,username,' . auth()->id(),
            ],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'required_unless:current_password,null', 'confirmed', 'min:8'],
        ];
    }

    // public function validated($key = null, $default = null)
    // {
    //     if ($this->current_password != null) {
    //         return array_merge(
    //             parent::validated($key, $default),
    //             [
    //                 'password' => Hash::make($this->password)
    //             ]
    //         );
    //     }

    //     return Arr::except(parent::validated($key, $default), 'password');
    // }
}
