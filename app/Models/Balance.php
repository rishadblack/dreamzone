<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function Withdrawal(): BelongsTo
    {
        return $this->belongsTo(Withdrawal::class);
    }

    public function scopeAvailableBalance(Builder $builder): mixed
    {
        return $builder->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 1 THEN `net_amount` END), 0)) - (COALESCE(SUM(CASE WHEN `flow` = 2 THEN `net_amount` END), 0))  AS `available_balance`");
    }

}