<?php

namespace App\Models;

use App\Enums\FuelType;
use App\Enums\Transmission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'mileage',
        'fuel_type',
        'transmission',
        'color',
    ];

    protected $casts = [
        'year'         => 'integer',
        'price'        => 'decimal:2',
        'mileage'      => 'integer',
        'fuel_type'    => FuelType::class,
        'transmission' => Transmission::class,
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(CarTranslation::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            Feature::class,
            'car_feature',
            'car_id',
            'feature_id'
        );
    }

    /**
     * Попереднє завантаження перекладів лише для поточної та основної мови
     * (щоб не робити зайвих запитів у циклі).
     */
    public function scopeWithTranslation(Builder $query): Builder
    {
        $locales = array_unique([app()->getLocale(), config('app.fallback_locale')]);

        return $query->with([
            'translations' => fn ($q) => $q->whereIn('locale', $locales),
        ]);
    }

    /**
     * Переклад обраною мовою, а якщо його немає, то основною мовою.
     */
    public function translate(): ?CarTranslation
    {
        return $this->translations->firstWhere('locale', app()->getLocale())
            ?? $this->translations->firstWhere('locale', config('app.fallback_locale'));
    }

    /** Чи показано переклад основною мовою замість обраної. */
    public function isFallback(): bool
    {
        $t = $this->translate();

        return $t !== null && $t->locale !== app()->getLocale();
    }

    public function getTitleAttribute(): string
    {
        return $this->translate()?->title ?? trim($this->brand . ' ' . $this->model);
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translate()?->description;
    }
}
