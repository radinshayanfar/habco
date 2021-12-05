<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'text',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'patient_id' => 'integer',
        'doctor_id' => 'integer',
        'pharmacist_id' => 'integer',
    ];

    public static function lazyLoadOnRole($prescriptions, $role)
    {
        if ($role === 'doctor') {
            $prescriptions->load('patient.user');
        } elseif ($role === 'patient') {
            $prescriptions->load('doctor.user', 'pharmacist.user');
        } elseif ($role === 'pharmacist') {
            $prescriptions->load('patient.user');
        }
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class, 'pharmacist_id');
    }
}
