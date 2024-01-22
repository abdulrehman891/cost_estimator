<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
class QuoteLineItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = [
        'created_by',
        'quotation_id',
        'product_id',
        'project_milestone_id',
        'unit_price',
        'discount_price',
        'quantity',
        'total_price'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function project_milestone(): BelongsTo
    {
        return $this->belongsTo(ProjectMilestone::class,'project_milestone_id');
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
