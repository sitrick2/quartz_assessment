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
Route::get('/', 'HomeController@index');

Route::get('/quiz', 'QuizController@show');
Route::get('/quiz', 'QuizController@create');
Route::get('/quiz/{quiz}', 'QuizController@edit');
Route::post('/quiz', 'QuizController@store');
Route::patch('/quiz/{quiz}', 'QuizController@update');
Route::delete('/quiz/{quiz}', 'QuizController@destroy');

Route::post('/question/{quiz}', 'QuestionController@store');
Route::patch('/question/{question}', 'QuestionController@update');
Route::delete('/question/{question}', 'QuestionController@destroy');

Route::patch('/answer/{answer}', 'AnswerController@update');

Auth::routes();

Route::get('/admin', function() {
    return redirect('/admin/quizzes');
})->name('home')->middleware('auth');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/quizzes', 'AdminController@index')->name('quiz.index');
    Route::get('/quiz', 'AdminController@showNewQuiz')->name('quiz.create');
    Route::get('quiz/{quiz}', 'AdminController@showEditQuiz')->name('quiz.edit');
    Route::post('quiz', 'AdminController@storeNewQuiz')->name('quiz.store');
    Route::patch('quiz/{quiz}', 'AdminController@updateQuiz')->name('quiz.update');
    Route::delete('quiz/{quiz}', 'AdminController@adminDeleteQuiz')->name('quiz.destroy');

});
