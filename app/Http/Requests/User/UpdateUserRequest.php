<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->user);
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
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $this->user->id
            ],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role' => ['required', new Enum(UserRole::class)],
        ];
    }

    public function validated($key = null, $default = null)
    {
        if ($this->password != null) {
            return array_merge(
                parent::validated($key, $default),
                [
                    'password' => Hash::make($this->password)
                ]
            );
        }

        return Arr::except(parent::validated($key, $default), 'password');
    }
}
