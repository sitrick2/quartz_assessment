<?php

namespace App\Http\Controllers;

use App\Models\Question;
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
     * @return array
     */
    private function validateRequest() :array
    {
        return request()->validate([
            'question_text' => 'required'
        ]);
    }
}
