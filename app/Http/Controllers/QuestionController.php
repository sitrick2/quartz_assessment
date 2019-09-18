<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Question $question
     * @return JsonResponse
     */
    public function update(Request $request, Question $question) :JsonResponse
    {
        $question->update($this->validateRequest());
        return response()->json($question);
    }

    /**
     * @param Quiz $quiz
     *
     * @return JsonResponse
     */
    public function store(Quiz $quiz) :JsonResponse
    {
        $question = new Question($this->validateRequest());
        $question->quiz()->associate($quiz);
        $question->save();
        return response()->json($question);
    }

    public function destroy(Question $question) :JsonResponse
    {
        $question->delete();
        return response()->json(['success' => true]);
    }

    /**
     * @return array
     */
    private function validateRequest() :array
    {
        return request()->validate([
            'question_text' => 'required'
        ]);
    }
}
