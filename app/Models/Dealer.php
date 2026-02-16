<?php
namespace App\Models;

use App\Models\OrderItem;
use App\Traits\StockTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StockTrait;

    protected $guarded = [];
    public $timestamps = true;

    public function scopeActive(Builder $query): mixed
    {
        return $query->whereStatus(1);
    }

    public function scopeOffice(Builder $query): mixed
    {
        return $query->whereNotNull('is_office');
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberTree(): BelongsTo
    {
        return $this->belongsTo(MemberTree::class, 'user_id', 'user_id');
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
