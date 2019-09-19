<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    public function index() :View
    {
        return view('admin.quiz_index')->with(['quizzes' => Quiz::all()]);
    }

    public function showNewQuiz() :View
    {
        return view('admin.quiz_edit')->with(['quiz' => new Quiz(), 'request' => request()]);
    }

    public function storeNewQuiz() :View
    {

    }

    public function showEditQuiz(Quiz $quiz) :View
    {
        return view('admin.quiz_edit')->with(['quiz' => $quiz]);
    }

    public function updateQuiz(Quiz $quiz) :View
    {
        $data = $this->validateUpdateRequest();

        $quiz->update(['title' => $data['title']]);

        $ids = [];
        foreach($quiz->questions as $question){
            if (isset($data['question'][$question->id])){
                $question->update([
                    'question_text' => $question['question_text']
                ]);

                foreach($question->answers as $answer){
                    if (isset($data['question'][$question->id]['answers'][$answer->id])){
                        $answer->update([
                            'text' => $data['question'][$question->id]['answers'][$answer->id]['answer_text'],
                            'correct' => $data['question'][$question->id]['answers'][$answer->id]['correct'] ?? $answer->correct
                        ]);
                    }
                }
            } else {
                $question->delete();
            }
        }
        $quiz->save();
        return view('admin.quiz_edit')->with(['quiz' => $quiz]);
    }

    public function adminDeleteQuiz() :View
    {

    }

    private function validateUpdateRequest() :array
    {
        return request()->validate([
            'title' => 'required',
            'question' => 'required|array',
            'question.*.question_text' => 'required|string',
            'question.*.answers' => 'required|array',
            'question.*.answers.*.answer_text' => 'required|string',
        ]);
    }
}
