<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cv_id',
        'document_id',
        'image',
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
     * Get the records associated with the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
