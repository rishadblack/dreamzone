<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $casts = [
        'is_distribute' => 'datetime',
        'close_date' => 'datetime',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
