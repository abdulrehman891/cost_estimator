<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'phone_number',
        'last_login_ip',
        'profile_photo_path',
        'two_factor_code',
        'two_factor_expires_at',
        'subscription_ends_at',
        'subscription_transaction_stripe_id',
        'subscription_latest_invoice_stripe_id',
    ];
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
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];
    public function productCategory(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
    public function productSubCategory(): HasMany
    {
        return $this->hasMany(ProductSubCategory::class);
    }
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        return $this->profile_photo_path;
    }
    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }
    public function projectMilestone()
    {
        return $this->hasMany(ProjectMilestone::class);
    }
    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function getDefaultAddressAttribute()
    {
        return $this->addresses?->first();
    }

    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;  // Prevent updating the 'updated_at' column
        $this->two_factor_code = rand(100000, 999999);  // Generate a random code
        $this->two_factor_expires_at = now()->addMinutes(10);  // Set expiration time
        $this->save();
    }

    public function resetTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
    public function quoteLineItem()
    {
        return $this->hasMany(QuoteLineItem::class);
    }
}
