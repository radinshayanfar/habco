<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'text',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'patient_id' => 'integer',
        'nurse_id' => 'integer',
    ];

    public static function lazyLoadOnRole($instructions, $role)
    {
        if ($role === 'nurse') {
            $instructions->load('patient.user');
        } elseif ($role === 'patient') {
            $instructions->load('nurse.user');
        }
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'nurse_id');
    }
}
