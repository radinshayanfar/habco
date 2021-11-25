<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "covid_19" => 'boolean',
        "respiratory" => 'boolean',
        "infectious" => 'boolean',
        "vascular" => 'boolean',
        "cancer" => 'boolean',
        "imuloical" => 'boolean',
        "diabetes" => 'boolean',
        "dangerous_area" => 'boolean',
        "pet" => "boolean",
    ];

    /**
     * Get the user that owns the record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
