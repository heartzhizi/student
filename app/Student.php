<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Student extends Model
{
    //
    public $timestamps = false;
    public function show(){
        $temp = DB::select('select * from students');
        return $temp;
    }

    public function searchTname($tid){
        if( is_array($tid)){
            $tname = array();
            for($i = 0; $i< count($tid);$i++)
                $tname[$i] = DB::select('select tname from teachers where tid = ?',[$tid[$i]]);
            return $tname;
        }else{
            return DB::select('select tname from teachers where tid = ?',[$tid]);
        }
    }

    public function insert($array1){

        $tid = DB::select('select * from teachers where tname = ? ',[$array1[4]]);
        DB::beginTransaction();
        $r1 = DB::table('students')->insertGetId(array('name'=>$array1[0],'sex'=>$array1[1],'age'=>$array1[2],'classid'=>$array1[3],'tid'=>$tid[0]->tid));
        $r2 = DB::update('update teachers set snum = ? where tid = ?',[$tid[0]->snum+1,$tid[0]->tid]);
        if(!$r1 || !$r2)
            DB::rollback();
        DB::commit();
//        return $temp;
    }

    public function edit($array){
        //1.修改students表，找到老师对应的tid修改；2.修改teachers表，原老师的学生数量-1，新老师学生数量+1；
        $old = DB::select('select snum from teachers where tname = ?',[$array[6]]);
        $new = DB::select('select * from teachers where tname = ?',[$array[5]]);
        DB::beginTransaction();
        $r1 = DB::update('update teachers set snum = ? where tname=?',[($old[0]->snum)-1,$array[6]]);
        $r2 = DB::update('update teachers set snum = ? where tname=?',[($new[0]->snum)+1,$array[5]]);
        $r3 =  DB::update('update students set name = ?,sex = ?,age = ?,classid = ?,tid = ? where Id=? ',[$array[1],$array[2],$array[3],$array[4],$new[0]->tid,$array[0]]);
        if(!$r1||!$r2||!$r3)
            DB::rollback();
        DB::commit();
    }

    public function deletes($id){
            $temp = DB::select('select tid from students where Id=?',[$id]);
            DB::table('students')->where('Id','=',$id)->delete();
            $snum = DB::select('select snum from teachers where tid=?',[$temp[0]->tid]);
            DB::update('update teachers set snum = ? where tid = ?',[$snum[0]->snum-1,$temp[0]->tid]);

    }

}
