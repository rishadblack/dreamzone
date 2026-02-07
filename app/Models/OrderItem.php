<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $dates   = ['deleted_at'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }

    public function Order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function Dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeIn($query)
    {
        return $query->whereFlow(1);
    }

    public function scopeOut($query)
    {
        return $query->whereFlow(2);
    }
}