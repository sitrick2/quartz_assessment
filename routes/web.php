<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/quiz', 'QuizController@store');
Route::patch('/quiz/{quiz}', 'QuizController@update');
Route::delete('/quiz/{quiz}', 'QuizController@destroy');

Route::post('/question/{quiz}', 'QuestionController@store');
Route::patch('/question/{question}', 'QuestionController@update');
Route::delete('/question/{question}', 'QuestionController@destroy');

Route::patch('/answer/{answer}', 'AnswerController@update');
