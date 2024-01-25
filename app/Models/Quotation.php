<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Quotation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['project_id','created_by','prepared_date','assembly_type','manufacturer','sq_field','parapet_length','warranty','sq_walls','building_height','deck_type','signnow_document_id','status','status_update_at'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

//    public function quoteLineItem(): HasMany
//    {
//        return $this->hasMany(QuoteTemplate::class);
//    }
//
//    public function quotationHistory(): HasMany
//    {
//        return $this->hasMany(QuotationHistory::class);
//    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
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

    public function quoteLineItem()
    {
        return $this->hasMany(QuoteLineItem::class);
    }
}
