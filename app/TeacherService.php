<?php
/**
 * Created by PhpStorm.
 * User: tal
 * Date: 2018/1/7
 * Time: 下午3:32
 */

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Runner\Exception;

    class TeacherService {

        public function insertTeacher($tid,$tname,$tpwd){
            $teacher = new Teacher();
            return $teacher->insert($tid,$tname,$tpwd);
        }
        public function selectByName($tname){
            $teacher = new Teacher();
            return $teacher->showByName($tname);
        }
        public function selectByTid($tid){
            $teacher = new Teacher();
            return $teacher->showByTid($tid);
        }
        public function verify($tname,$tpwd){
            $teacher = new Teacher();
            return $teacher->verifyNP($tname,$tpwd);
        }
        public function showTeacher(){
            $teacher = new Student();
            return $teacher->showST();
        }

        public function deleteTeacher($tname){
            $teacher = new Teacher();
            $student = new Student();
            try{
                DB::beginTransaction();
                $teacher->deleteteacher($tname);
                $student->deleteByTname($tname);
                DB::commit();
            }catch (Exception $e){
                DB::rollback();
            }
        }

        public function showTS($tname){
            $student = new Student();
            return $student->showTS($tname);
        }

        public function showTname(){
            $teacher = new Teacher();
            return $teacher->showname();
        }
    }
?>