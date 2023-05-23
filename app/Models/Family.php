<?php

namespace App\Models;

use App\Enums\FamilyStatus;
use App\Enums\FamilyType;
use App\Enums\HousingType;
use App\Enums\IncomeType;
use App\Enums\ProviderSocialStatus;
use App\QueryBuilders\FamilyQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rules\Enum;

class Family extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'provider_social_status' => ProviderSocialStatus::class,
        'status' => FamilyStatus::class,
        'type' => FamilyType::class,
        'housing_type' => HousingType::class,
        'income_type' => IncomeType::class,
        'docs' => 'array',
    ];

    public static function getValidationRules(): array
    {
        return [
            'provider_name' => ['required', 'string', 'max:255'],
            'provider_phone' => ['required', 'string', 'max:255'],
            'members_count' => ['nullable', 'min:0', 'max:100'],
            'youngers_count' => ['nullable', 'min:0', 'max:100'],
            'provider_social_status' => ['nullable', new Enum(ProviderSocialStatus::class)],
            'status' => ['nullable', new Enum(FamilyStatus::class)],
            'type' => ['nullable', new Enum(FamilyType::class)],
            'address' => ['nullable', 'string', 'max:500'],
            'income' => ['nullable', 'integer', 'min:0'],
            'housing_type' => ['nullable', new Enum(HousingType::class)],
            'rent_cost' => ['nullable', 'integer', 'min:0'],
            'shares_count' => ['nullable', 'integer', 'min:0'],
            'income_type' => ['nullable', new Enum(IncomeType::class)],
            'other_orgs' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'docs' => ['nullable', 'array'],
            'docs.*' => ['nullable', 'file', 'max:1024'],
            'city_id' => ['nullable', 'exists:cities,id'],
        ];
    }

    public function newEloquentBuilder($builder)
    {
        return new FamilyQueryBuilder($builder);
    }

    //---------------------------------------------------
    // Relationships
    //---------------------------------------------------

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
