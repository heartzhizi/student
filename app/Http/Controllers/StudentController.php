<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function show(){
        $stu = new Student();
        $students = $stu->show();
        $tid = array_column($students,'tid');
        $tname = $stu->searchTname($tid);
        return view("index",['stud'=>$students,'tname'=>$tname]);
    }
    public function create(Request $request){
        $array1 = array();
        //获取参数
        $array1[0] = $request->input("name");
        $array1[1] = $request->input("sex");
        $array1[2] = $request->input("age");
        $array1[3] = $request->input("classid");
        $array1[4] = $request->input("tname");
        //插入数据；
        $student = new Student();
        $student->insert($array1);
        return $array1;
    }

    public function edit( Request $request ){
        $array1 = array();
        $array1[0] = $request->input('id');
        $array1[1] = $request->input('name');
        $array1[2] = $request->input('sex');
        $array1[3] = $request->input('age');
        $array1[4] = $request->input('classid');
        $array1[5] = $request->input('tname');
        $array1[6] = $request->input('oldtname');
        $student = new Student();
        $student->edit($array1);
        return $array1;
    }

    public function destroy($id){

       $student = new Student();
       $student->deletes($id);
        return $id;
    }
}
