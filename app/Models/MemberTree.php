<?php
namespace App\Models;

use App\Traits\PointTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberTree extends Model
{
    use HasFactory;
    use SoftDeletes;
    use PointTrait;

    protected $guarded = [];
    public $timestamps = true;
    protected $casts   = [
        'is_premium' => 'datetime',
        'is_valid' => 'datetime',
        'is_founder' => 'datetime',
        'is_cashback' => 'datetime',
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

    public function Point(): BelongsTo
    {
        return $this->belongsTo(Point::class, 'user_id', 'user_id');
    }
}
