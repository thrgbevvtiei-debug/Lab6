<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';

    public const CREATED_AT = 'dt_created';
    public const UPDATED_AT = 'dt_updated';

    protected $fillable = [
        'title',
        'description',
        'text',
        'category_id',
        'user_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function filters(): BelongsToMany
    {
        return $this->belongsToMany(
            Filter::class,
            'blog_filter',
            'blog_id',
            'filter_id'
        );
    }

    public function translations(): HasMany
    {
        return $this->hasMany(BlogTranslation::class, 'blog_id', 'blog_id');
    }

    /** Підвантажує переклад лише для поточної мови (одним запитом). */
    public function scopeWithTranslation(Builder $query): Builder
    {
        return $query->with([
            'translations' => fn ($q) => $q->where('locale', app()->getLocale()),
        ]);
    }

    /** Переклад поточною мовою або null (тоді показуємо оригінал). */
    public function translation(): ?BlogTranslation
    {
        if (app()->getLocale() === config('app.fallback_locale')) {
            return null;
        }

        return $this->translations->firstWhere('locale', app()->getLocale());
    }

    /** Чи показано оригінал замість перекладу обраною мовою. */
    public function isFallback(): bool
    {
        return app()->getLocale() !== config('app.fallback_locale')
            && $this->translation() === null;
    }

    // Аксесори: t_title, t_description, t_text (переклад або оригінал)
    public function getTTitleAttribute(): string
    {
        return $this->translation()?->title ?? $this->title;
    }

    public function getTDescriptionAttribute(): ?string
    {
        return $this->translation()?->description ?? $this->description;
    }

    public function getTTextAttribute(): ?string
    {
        return $this->translation()?->text ?? $this->text;
    }
}
