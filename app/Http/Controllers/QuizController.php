<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create() :JsonResponse
    {
        if (request('quiz_id')){
            $quiz = Quiz::find(request('quiz_id'));
        } else {
            $quiz = Quiz::first();
        }
        return response()->json($quiz->load('questions.answers'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request) :JsonResponse
    {
        $quiz = Quiz::create($this->validateRequest());

        return response()->json($quiz);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show() :JsonResponse
    {
        if (request('quiz_id')){
            $quiz = Quiz::find(request('quiz_id'));
        } else {
            $quiz = Quiz::first();
        }
        return response()->json($quiz->load('questions.answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Quiz  $quiz
     * @return View
     */
    public function edit(Quiz $quiz) :View
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Quiz  $quiz
     * @return JsonResponse
     */
    public function update(Request $request, Quiz $quiz) :JsonResponse
    {
        $quiz->update($this->validateRequest());

        return response()->json($quiz);
    }

    /**
     * @param Quiz $quiz
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Quiz $quiz) :JsonResponse
    {
        $quiz->delete();
        return response()->json(['success' => true]);
    }

    /**
     * @return array
     */
    private function validateRequest() :array
    {
        return request()->validate([
            'title' => 'required|string'
        ]);
    }
}
