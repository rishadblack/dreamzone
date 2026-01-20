<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'birth' => 'datetime',
        'is_agree' => 'datetime',
        'is_approve' => 'datetime',
        'is_banned' => 'datetime',
    ];

    public function Balance(): HasMany
    {
        return $this->hasMany(Balance::class);
    }

    public function Income(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function Point(): HasMany
    {
        return $this->hasMany(Point::class);
    }

    public function Withdrawal(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function Fund(): HasMany
    {
        return $this->hasMany(Fund::class);
    }

    public function Order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function metaTradeBalance(): HasMany
    {
        return $this->hasMany(MetaTradeBalance::class);
    }

    public function memberTree(): HasOne
    {
        return $this->hasOne(MemberTree::class);
    }

    public function getProfileUrlAttribute()
    {
        if ($this->profile) {
            return asset_storage($this->profile);
        }

        $name = urlencode($this->name ?? 'User');

        return "https://ui-avatars.com/api/?background=00ad57ab&color=fff&name={$name}";
    }

    public function Dealer(): HasOne
    {
        return $this->hasOne(Dealer::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('is_banned');
    }

    public function scopeTotalIncomes($query)
    {
        foreach (config('mlm.income_list') as $key => $value) {
            $query->withSum(['Income as ' . $value['name'] . '_income' => function ($q) use ($value) {
                $q->whereType($value['income_type'])->whereWalletType(1)->whereFlow(1)->whereStatus(1);
            }], 'net_amount');
        }
    }
}