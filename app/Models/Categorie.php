<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function questionsEvaluation()
    {
        return $this->hasMany(QuestionsEvaluation::class);
    }
}
