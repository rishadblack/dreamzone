<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
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

    public function Balance(): HasOne
    {
        return $this->hasOne(Balance::class);
    }

    public function Income(): HasOne
    {
        return $this->hasOne(Income::class);
    }
}
