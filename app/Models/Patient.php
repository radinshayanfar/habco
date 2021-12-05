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
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Get the records associated with the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, null, 'patient_id', 'doctor_id');
    }

    public function nurses()
    {
        return $this->belongsToMany(Nurse::class, null, 'patient_id', 'nurse_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class, 'patient_id');
    }
}
