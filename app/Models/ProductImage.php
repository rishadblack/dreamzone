<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function scopeActive(Builder $query): mixed
    {
        return $query->whereStatus(1);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDefault($query)
    {
        return $query->whereNotNull('is_default');
    }
}
