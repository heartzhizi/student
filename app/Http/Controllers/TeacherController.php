<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TeacherController extends Controller
{
    //
    public function register(Request $request){
        $tid = $request->input("tid");
        $tname = $request->input("tname");
        $tpwd = $request->input("tpwd");
        $teacher = new Teacher();
        $flag = $teacher->insert($tid,$tname,$tpwd);
        return $flag;
    }

    public function login(Request $request){
        $tname = $request->input("tname");
        $tpwd = $request->input("tpwd");
        $teacher = new Teacher();
        $flag = $teacher->login($tname,$tpwd);
        if($flag == 1){
            Redis::set('user',$tname);
        }
        return $flag;
    }

    public function show(Request $request){
        $teachers = new Teacher();
        $teacher = $teachers->show();
        return view("teacherinfo",['teacher'=>$teacher]);
    }

    public function delteacher(Request $request){
        $tname = $request->input('tname');
        $teacher = new Teacher();
        $temp = $teacher->deleteteacher($tname);
        if($tname == Redis::get('user')){
            Redis::del('user');
            return view('teacher_register');
        }
        return $temp;
    }

    public function showtid(Request $request){
        $tname = $request->input('tname');
        $teacher = new Teacher();
        $temp = $teacher->showtid($tname);
        $student = new Student();
        $tid = array_column($temp,'tid');

        $tname = $student->searchTname($tid);

        return view("index",['stud'=>$temp,'tname'=>$tname]);
    }

    public function showname(){
        $teacher = new Teacher();

        return   $teacher->showname();
    }
}
