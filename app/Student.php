<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Student extends Model
{
    //
    public $timestamps = false;
//    显示所有学生
    public function show(){
        $temp = DB::select('select * from students');
        return $temp;
    }
//    显示老师的学生具体信息
    public function showTS($tname){
        return DB::select('select * from students where tname = ?',[$tname]);
    }
//    显示老师的学生数量
    public function showST(){
        return  DB::select('select tname,count(*) as snum from students  group by tname');
    }
//    创建学生
    public function insert($name,$sex,$age,$classid,$tname){

       DB::table('students')->insertGetId(array('name'=>$name,'sex'=>$sex,'age'=>$age,'classid'=>$classid,'tname'=>$tname));
    }
//  编辑学生
    public function edit($name,$sex,$age,$classid,$tname,$id){

        DB::update('update students set name = ?,sex = ?,age = ?,classid = ?,tname = ? where Id=? ',[$name,$sex,$age,$classid,$tname,$id]);

    }
//  根据id删除学生
    public function deleteById($id){
            DB::table('students')->where('Id','=',$id)->delete();
    }
//  根据老师姓名删除学生
    public function  deleteByTname($tname)
    {
        DB::delete('delete from students where tname = ?',[$tname]);
    }

}
