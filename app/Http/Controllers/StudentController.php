<?php

namespace App\Http\Controllers;
use App\Student;
use App\StudentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function show(){
        $stu = new StudentService();
        $students = $stu->showStudent();
        return view("index",['stud'=>$students]);
    }
    public function create(Request $request){
        //插入数据；
        $student = new StudentService();
        $student->addStudent($request->input("name"),$request->input("sex"),$request->input("age"),$request->input("classid"),$request->input("tname"));
        return array($request->input("name"),$request->input("sex"),$request->input("age"),$request->input("classid"),$request->input("tname"));
    }

    public function edit(Request $request ){

        $student = new StudentService();
        $student->editStudent($request->input('name'),$request->input('sex'),$request->input('age'),$request->input('classid'),$request->input('tname'),$request->input('id'));
        return array($request->input('id'),$request->input('name'),$request->input('sex'),$request->input('age'),$request->input('classid'),$request->input('tname'));
    }

    public function destroy($id){
       $student = new StudentService();
       $student->deleteStudent($id);
        return $id;
    }
}
