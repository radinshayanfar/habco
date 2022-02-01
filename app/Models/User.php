<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
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
    protected $casts = [
        'age' => 'integer',
    ];

    /**
     * Retrieves user by phone number
     * @param $phone string
     * @return User
     */
    public static function findByPhoneOrFail($phone)
    {
        return self::where('phone', $phone)->firstOrFail();
    }

    public function createRoleRecord()
    {
        switch ($this->role) {
            case 'patient':
                $this->patient()->create();
                break;
            case 'doctor':
                $this->doctor()->create();
                break;
            case 'nurse':
                $this->nurse()->create();
                break;
            case 'pharmacist':
                $this->pharmacist()->create();
                break;
        }
    }

    public static function createWithRole(Request $request)
    {
        $user = User::create(request(['email', 'phone', 'role']));

        $user->createRoleRecord();

        return $user;
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
     * Get the records associated with the user.
     */

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }

    public function pharmacist()
    {
        return $this->hasOne(Pharmacist::class);
    }
}
