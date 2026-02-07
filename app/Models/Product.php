<?php
namespace App\Models;

use App\Models\ProductImage;
use App\Traits\StockTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StockTrait;

    protected $guarded = [];
    public $timestamps = true;
    protected $dates   = ['deleted_at'];

    public function scopeActive(Builder $query): mixed
    {
        return $query->whereStatus(1);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function defaultImage()
    {
        return $this->hasOne(ProductImage::class)->default();
    }

    public function getImageUrlAttribute()
    {
        if ($this->defaultImage) {
            return $this->defaultImage->image_url;
        } else {
            return 'gallery/not_found.png';
        }
    }

    public function scopeFeatured($query)
    {
        return $query->whereNotNull('is_featured');
    }

    public function Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereLike([
            'name',
            'code',
            'Brand.name',
            'Category.name',
        ], $search);
    }
}