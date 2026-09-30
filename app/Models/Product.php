<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand',
        'name',
        'slug',
        'sku',
        'description',
        'specs',
        'price',
        'stock_quantity',
        'images',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'images' => 'array',
        'specs' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
