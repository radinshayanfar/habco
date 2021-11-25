<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'national_number',
        'address',
        'phone',
        'age',
        'gender',
        'role',
//        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
//        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];

    /**
     * Retrieves user by phone number
     * @param $phone string
     * @return User
     */
    public static function findByPhone($phone)
    {
        return self::firstWhere('phone', $phone);
    }

    /**
     * Retrieves user by national number
     * @param $national_number string
     * @return User
     */
    public static function findByNN($national_number)
    {
        return self::firstWhere('national_number', $national_number);
    }

    /**
     * Creates a login token for user
     * This method revokes all users created tokens
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createLoginToken()
    {
        // Revoking all tokens
        $this->tokens()->delete();

        return $this->createToken('login-token', ['login']);
    }

    /**
     * Creates an app token for user
     * This method revokes all users created tokens
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createAppToken()
    {
        // Revoking all tokens
        $this->tokens()->delete();

        return $this->createToken('app-token', ['enter-app']);
    }

    /**
     * Check if user has filled disease records
     * @return bool
     */
    public function hasFilledRecords()
    {
        return $this->diseaseRecord !== null;
    }

    public function isRegistrationComplete()
    {
        return $this->habco_id != null;
    }

    /**
     * Get the records associated with the user.
     */
    public function diseaseRecord()
    {
        return $this->hasOne(DiseaseRecord::class);
    }
}
