<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


class QuotationTemplate extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['created_by','prepared_date','assembly_type','manufacturer','sq_field','parapet_length','warranty','sq_walls','building_height','deck_type'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
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

    public function quoteTemplateLineItem()
    {
        return $this->hasMany(QuoteTemplateLineItem::class);
    }
}