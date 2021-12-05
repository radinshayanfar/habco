<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
//        'cv_id',
//        'document_id',
        'image',
        'image_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
//        'cv_id' => 'integer',
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

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function cv()
    {
        return $this->belongsTo(Document::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, null, 'nurse_id', 'patient_id');
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class, 'nurse_id');
    }
}
