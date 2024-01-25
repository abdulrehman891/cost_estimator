<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'weight',
        'length',
        'width',
        'height',
        'material',
        'color',
        'stock_quantity',
        'product_category_id',
        'product_subcategory_id',
        'sku',
        'created_by',
    ];

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['id'];
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_subcategory()
    {
        return $this->belongsTo(ProductSubCategory::class);
    }

    public function quoteLineItem()
    {
        return $this->hasMany(QuoteLineItem::class);
    }

    public function productPriceHistory()
    {
        return $this->hasMany(ProductPriceHistory::class);
    }
}
