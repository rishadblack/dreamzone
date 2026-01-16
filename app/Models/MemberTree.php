<?php

namespace App\Models;

use App\Models\Board;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberTree extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $casts = [
        'is_premium' => 'datetime',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

     public function Dealer()
    {
        return $this->belongsTo(Dealer::class, 'user_id', 'user_id');
    }

    public function Balance(): HasMany
    {
        return $this->hasMany(Balance::class, 'user_id', 'user_id');
    }

    public function Sponsor(): HasMany
    {
        return $this->hasMany(self::class, 'sponsor_id', 'user_id');
    }

    public function Placement(): HasMany
    {
        return $this->hasMany(self::class, 'placement_id', 'user_id');
    }

    public function Fund(): HasMany
    {
        return $this->hasMany(Fund::class, 'user_id', 'user_id');
    }

    public function bySponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id')->withDefault();
    }

    public function byPlacement(): BelongsTo
    {
        return $this->belongsTo(User::class, 'placement_id')->withDefault();
    }

    public function Package(): BelongsTo
    {
        return $this->belongsTo(Package::class)->withDefault();
    }
}