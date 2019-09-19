<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $guarded = [];

    public static function boot() :void
    {
        parent::boot();
        static::created(static function($model) {
            $answers = [];

            foreach ([0,1,2,3] as $answerIndex) {
                $answers[$answerIndex] = new Answer([
                    'text' => 'Default Incorrect Answer',
                    'correct' => false
                ]);
                $answers[$answerIndex]->question()->associate($model);
                $answers[$answerIndex]->save();
            }

            $correctAnswer = $model->answers[random_int(0, 3)];
            $correctAnswer->correct = true;
            $correctAnswer->save();
        });

        static::deleting(function($model) { // before delete() method call this
            foreach ($model->answers as $answer){
                $answer->delete();
            }
            // do the rest of the cleanup...
        });
    }

    public function quiz() :BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function answers() :HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function path() :string
    {
        return '/question/' . $this->id;
    }
}
