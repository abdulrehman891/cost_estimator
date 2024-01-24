<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Customer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
    ];

    public function quotation(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

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
}
