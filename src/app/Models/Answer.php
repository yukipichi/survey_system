<?php

namespace App\Models;

use App\Models\Age;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['fullname', 'gender', 'age_id', 'email', 'is_send_email', 'feedback'];

    public function age()
    {
        return $this->belongsTo(Age::class);
    }
}
