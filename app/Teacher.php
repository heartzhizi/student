<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Runner\Exception;

class Teacher extends Model
{
    //
    public function insert($tid,$tname,$tpwd){
        DB::insert('insert into teachers(tid,tname,password) values(?,?,?)',[$tid,$tname,$tpwd]);
        return 1;
    }

    public function verifyNP($tname,$tpwd){

       return DB::select('select * from teachers where tname = ? and password = ?',[$tname,$tpwd]);
    }

    public function showByName($tname){
        $user = DB::select('select * from teachers where tname = ?',[$tname]);
        return $user;
    }

    public function showByTid($tid){
        return  DB::select('select * from teachers where tid = ?',[$tid]);
    }

    public function deleteteacher($tname){

        DB::delete('delete from teachers where tname = ?',[$tname]);
        return 1;
    }

    public function showname(){
       return DB::select('select tname from teachers');
    }
}
