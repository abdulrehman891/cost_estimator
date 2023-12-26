<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class ProductCategory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function product_subCategories(): HasMany
    {
        return $this->hasMany(ProductSubCategory::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

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
}
