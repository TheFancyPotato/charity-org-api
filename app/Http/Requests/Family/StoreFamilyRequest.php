<?php

namespace App\Http\Requests\Family;

use App\Enums\FamilyStatus;
use App\Enums\FamilyType;
use App\Enums\HousingType;
use App\Enums\IncomeType;
use App\Enums\ProviderSocialStatus;
use App\Models\Family;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class StoreFamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Family::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return Family::getValidationRules();
    }
}
