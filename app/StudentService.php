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

    class StudentService {

        public function showStudent(){
           $student = new Student();
            return $student->show();
        }

        public function editStudent($name,$sex,$age,$classid,$tname,$id){
            $student = new Student();
            $student->edit($name,$sex,$age,$classid,$tname,$id);
        }

        public function deleteStudent($id){
            $student = new Student();
            $student->deletes($id);
        }
        public function showST(){
            $student = new Student();
            return $student->showST();
        }
        public function addStudent($name,$sex,$age,$classid,$tname){
            $student = new Student();
            $student->insert($name,$sex,$age,$classid,$tname);
        }
    }
?>