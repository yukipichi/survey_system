<?php

namespace App\Models;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    protected $fillable = ['age', 'sort'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
