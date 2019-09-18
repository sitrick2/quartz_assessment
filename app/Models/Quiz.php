<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $guarded = [];

    public static function boot() :void
    {
        parent::boot();
        static::saved(static function($model) {
            $question = new Question([
                'question_text' => 'Default Question'
            ]);
            $question->quiz()->associate($model);
            $question->save();
        });

        static::deleting(static function($model) { // before delete() method call this
            foreach ($model->questions as $question){
                $question->delete();
            }
            // do the rest of the cleanup...
        });
    }

    public function path() :string
    {
        return 'quiz/' . $this->id;
    }

    public function questions() :HasMany
    {
        return $this->hasMany(Question::class);
    }
}
