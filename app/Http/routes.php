<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'api'], function()
{
    Route::get('subject/students', 'SubjectController@getStudents');
    Route::post('subject/students', 'SubjectController@addStudents');

    Route::get('teacher/students', 'TeacherController@getStudents');
    Route::get('teacher/subjects', 'TeacherController@getSubjects');
    Route::get('teacher/subject/quizzes', 'TeacherController@getSubjectQuizzes');
    Route::get('teacher/quiz/{id}', 'TeacherController@getQuiz');
    Route::put('teacher/update/question', 'TeacherController@updateQuestion');
    Route::delete('teacher/delete/question', 'TeacherController@deleteQuestion');

    
    Route::get('student/subject/{id}', 'StudentController@getSubject');
    Route::get('student/subjects', 'StudentController@getSubjects');
    Route::get('student/quizzes', 'StudentController@getQuizzes');
    Route::get('student/quiz/{id}', 'StudentController@getQuiz');
    Route::post('student/submit/quiz/{id}', 'StudentController@submitQuiz');

    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::put('user/password', 'UserController@changePassword');

    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::resource('user', 'UserController');
    Route::resource('subject', 'SubjectController');
    Route::resource('quiz', 'QuizController');

});
Route::get('/record/user', function(Request $request) {
    
    return ['response' => 'success'];
});