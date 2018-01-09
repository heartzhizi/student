<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use App\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
class TeacherController extends Controller
{

    public function register(Request $request){
        $tid = $request->input("tid");
        $tname = $request->input("tname");
        $tpwd = $request->input("tpwd");
        $teacher = new TeacherService();
//        1，注册成功；2，工号重复；3，姓名重复；
        $t = $teacher->selectByName($tname);
        if(count($t) !=0)
            return 3;
        $t = $teacher->selectByTid($tid);
        if( count($t) != 0)
            return 2;
        $flag = $teacher->insertTeacher($tid,$tname,$tpwd);
        return $flag;
    }

    public function login(Request $request){
//        1. 用户正常登陆 2 用户不存在 3 用户名密码不匹配
        $tname = $request->input("tname");
        $tpwd = $request->input("tpwd");
        $teacher = new TeacherService();
        $t = $teacher->selectByName($tname);
        if(count($t) == 0)
            return 2;
        $t = $teacher->verify($tname,$tpwd);
        if(count($t) == 0)
            return 3;
        else {

            Cookie::queue('user',$tname,1440,$httpOnly=false);
            return 1;
        }
        return 1;
    }
//  显示老师信息
    public function show(Request $request){
        $teachers = new TeacherService();
        $tname = $teachers->showTname();
        $teacher = $teachers->showTeacher();
        $len = count($teacher);
        $temp = $len;
//        找到学生数量是0的老师
        for($i = 0; $i< count($tname);$i++){
            for($j=0; $j<$len; $j++){
                if($tname[$i]->tname == $teacher[$j]->tname)
                    break;
            }
            if($j>= $len){
                $object = new \stdClass();
                $object->tname = $tname[$i]->tname;
                $object->snum = 0;
                $teacher[$temp++] = $object;
            }
        }
        return view("teacherinfo",['teacher'=>$teacher]);
    }
//  删除老师
    public function delteacher(Request $request){
        $tname = $request->input('tname');
        $teacher = new TeacherService();
        $temp = $teacher->deleteTeacher($tname);

        $cookie = Cookie::forget('user');
        Cookie::queue('user',null,1440,$httpOnly=false);
//        if($tname == Redis::get('user')){
//            Redis::del('user');
//            return view('teacher_register');
//        }
//        return $temp;
    }
//  显示老师的学生
    public function showTeaStu(Request $request){
        $teacher = new TeacherService();
        $temp = $teacher->showTS($request->input('tname'));
        return view("index",['stud'=>$temp]);
    }
//    显示所有老师姓名
    public function showname(){
        $teacher = new TeacherService();
        return   $teacher->showTname();
    }
}
