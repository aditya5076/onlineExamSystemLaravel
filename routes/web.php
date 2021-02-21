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



// Auth::routes([

// 	'register'=>false,
// 	'reset'=>false,
// 	'verify'=>false
// ]);

// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('quiz/{quizId}','ExamController@getQuizQuestions')->middleware('auth');

// Route::post('quiz/create','ExamController@postQuiz')->middleware('auth');

// Route::get('/result/user/{userId}/quiz/{quizId}','ExamController@viewResult')->middleware('auth');
// Route::group(['middleware'=>'isAdmin'],function(){
// 	Route::get('/', function () {
//     return view('admin.index');
// });

// 	Route::resource('quiz','QuizController');
// 	Route::resource('question','QuestionController');
// 	Route::resource('user','UserController');

// 	Route::get('/quiz/{id}/questions','QuizController@question')->name('quiz.question');

// 	Route::get('exam/assign','ExamController@create')->name('user.exam');
// 	Route::post('exam/assign','ExamController@assignExam')->name('exam.assign');
//   	Route::get('exam/user','ExamController@userExam')->name('view.exam');
// 	Route::post('exam/remove','ExamController@removeExam')->name('exam.remove');
//    Route::get('result','ExamController@result')->name('result');
//    Route::get('result/{userId}/{quizId}','ExamController@userQuizResult');





// });

// use Illuminate\Routing\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes([
	'register' => false,
]);

// For Guests
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	// get question linked with quiz
	Route::get('user/quiz/{quizId}', 'ExamController@getQuizQuestions')->name('quiz.questions');
	Route::post('quiz/create', 'ExamController@postQuiz');

	// Result
	Route::get('result/user/{userId}/quiz/{quizId}', 'ExamController@viewResult');
});


// For Admin
Route::group(['middleware' => 'isAdmin'], function () {


	Route::get('/', function () {
		return view('admin.index');
	});
	// get all questions related to quiz
	Route::get('quiz/{id}/questions', 'Quizcontroller@question')->name('quiz.question');
	Route::resource('quiz', 'Quizcontroller');
	Route::resource('question', 'QuestionController');
	Route::resource('user', 'UserController');

	// assign exam
	Route::get('exam/assign', 'ExamController@create')->name('view.exam');
	Route::post('exam/assign', 'ExamController@assignExam')->name('assign.exam');
	Route::get('exam/user', 'ExamController@userExam')->name('exam.user');
	Route::post('exam/remove', 'ExamController@removeExam')->name('exam.remove');

	// view result
	Route::get('result', 'ExamController@resultAdmin')->name('view.result');
	Route::get('result/{userId}/{quizId}', 'ExamController@userQuizResult');
});
