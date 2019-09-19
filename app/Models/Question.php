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
        static::saved(static function($model) {
            if (($model->answers === null || $model->answers->count() === 0) && !isset(request()->all()['question'][-1])) {
                $counter = 0;
                while($counter < 4) {
                    $model->answers()->create([
                        'text' => 'Default Incorrect Answer',
                        'correct' => time() % 2 === 0
                    ]);
                    $counter++;
                }
            }
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
