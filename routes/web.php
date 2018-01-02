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
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('index');
});


Route::get('/search','StudentController@show');
Route::get('edit/','StudentController@edit');
Route::any('del/{id}','StudentController@destroy');
Route::get('/create','StudentController@create');

Route::get('/register',function(Request $request){
    if($request->session()->has('user') == false){
        $temp = null;
    }else
        $temp = $request->session()->get('user');
    return view("teacher_register",['session'=>$temp]);
});

Route::get('/register1','TeacherController@register');

Route::get('/login',function (){
    return view("login");
});

Route::get('/login1',"TeacherController@login");

Route::get('/teacherinfo',"TeacherController@show");
Route::get('/delteacher',"TeacherController@delteacher");

Route::get('/showtid','TeacherController@showtid');

Route::get('/logout',function (Request $request){

    Redis::set('user',null);
    return view("login");
});

Route::get('/showname','TeacherController@showname');