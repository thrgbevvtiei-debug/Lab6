<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    protected $fillable = ['name'];

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(
            Car::class,
            'car_feature',
            'feature_id',
            'car_id'
        );
    }
}
