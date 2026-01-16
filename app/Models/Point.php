<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Point extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function scopeAvailablePoint(Builder $builder): mixed
    {
        return $builder->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 1 THEN `value` END), 0)) - (COALESCE(SUM(CASE WHEN `flow` = 2 THEN `value` END), 0))  AS `available_point`");
    }

    public function scopeUpgradePoint(Builder $builder): mixed
    {
        return $builder->selectRaw("COALESCE(SUM(CASE WHEN `flow` = 2 AND `type` = 2 THEN `value` END), 0)  AS `upgrade_point`");
    }
}
