<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dealer extends Model
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

    public function memberTree(): BelongsTo
    {
        return $this->belongsTo(MemberTree::class,'user_id','user_id');
    }
}