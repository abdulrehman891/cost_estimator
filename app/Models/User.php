<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
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
    public function quoteLineItem()
    {
        return $this->hasMany(QuoteLineItem::class);
    }

}
