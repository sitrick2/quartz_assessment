<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function update(Answer $answer) :JsonResponse
    {
        $answer->update($this->validateRequest());
        return response()->json($answer);
    }

    /**
     * @return array
     */
    private function validateRequest() :array
    {
        return request()->validate([
            'text' => 'required',
            'correct' => 'required'
        ]);
    }
}
