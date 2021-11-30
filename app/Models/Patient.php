<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        'user_id',
        'habco_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'covid_19' => 'boolean',
        'respiratory' => 'boolean',
        'infectious' => 'boolean',
        'vascular' => 'boolean',
        'cancer' => 'boolean',
        'imuloical' => 'boolean',
        'diabetes' => 'boolean',
        'dangerous_area' => 'boolean',
        'pet' => 'boolean',
        'med_staff' => 'boolean',
    ];

    /**
     * Get the records associated with the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
