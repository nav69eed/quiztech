<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempteduser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
    ];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}

