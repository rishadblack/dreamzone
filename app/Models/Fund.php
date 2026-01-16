<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fund extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    protected $casts = [
        'is_attached_request' => 'datetime',
        'is_attached' => 'datetime',
        'is_detached_request' => 'datetime',
        'is_detached' => 'datetime',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Balance(): HasMany
    {
        return $this->hasMany(Balance::class, 'user_id', 'user_id');
    }


}