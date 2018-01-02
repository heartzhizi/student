<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class Teacher extends Model
{
    //
    public function insert($tid,$tname,$tpwd){
        $temp = DB::table('teachers')->where('tid','=',$tid)->get();
       //1，注册成功；2，工号重复；3，姓名重复；
        if(count($temp) !=0)
         return 2;
        $temp = DB::table('teachers')->where('tname','=',$tname)->get();
        if( count($temp) !=0)
            return 3;
        //insert operation
        DB::insert('insert into teachers(tid,tname,password,snum) values(?,?,?,?)',[$tid,$tname,$tpwd,0]);
        return 1;
    }

    public function login($tname,$tpwd){
       //not logining...
        $temp = DB::select('select * from teachers where tname = ?',[$tname]);
        if(count($temp) == 0)
            return 2;
       $temp =  DB::select('select * from teachers where tname = ? and password = ?',[$tname,$tpwd]);
        if(count($temp) == 0)
            return 3;
        else if(count($temp) >0)
            return 1;
    }

    public function show(){
//        if(Redis::exists('teacher_show')){
//            $teacher = unserialize(Redis::get('teacher_show'));
//        }else{
            $teacher = DB::select('select * from teachers');
//            Redis::set('teacher_show',serialize($teacher));
//        }

        return $teacher;
    }
    public function showtid($tname){
        $tid = DB::select('select tid from teachers where tname =?',[$tname] );
        var_dump($tid);
        $user = DB::select('select * from students where tid = ?',[$tid[0]->tid]);
        return $user;
    }
    public function deleteteacher($tname){
        $tid = DB::select('select tid from teachers where tname =?',[$tname] );
        DB::beginTransaction();
        $r1 =  DB::delete('delete from students where tid =?',[$tid[0]->tid]);
        $r2 =  DB::delete('delete from teachers where tname = ?',[$tname]);
        if(!$r1 || !$r2)
            DB::rollback();
        DB::commit();

        return 1;
    }

    public function showname(){
       return DB::select('select tname from teachers');
    }
}
