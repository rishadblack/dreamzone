<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $casts   = [
        'close_time' => 'datetime',
        'share_date' => 'datetime',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberTree(): HasOne
    {
        return $this->hasOne(MemberTree::class, 'user_id', 'user_id');
    }

    public function Dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePaid($query)
    {
        return $query->wherePaymentStatus(1);
    }

}