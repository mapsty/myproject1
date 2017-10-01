<?php
class CatsTableSeeder extends Seeder {
     public function run(){
       DB::table('cats')->insert(array(
         array('id'=>1,  'name'=>"Cat1", 'date_of_birth'=>'2017-09-11', 'breed_id'=>1, 'created_at'=>'2017-09-18', 'updated_at'=>'2017-09-18'),
         array('id'=>2,  'name'=>"Cat2", 'date_of_birth'=>'2017-10-11', 'breed_id'=>2, 'created_at'=>'2017-09-18', 'updated_at'=>'2017-09-18'),
         array('id'=>3,  'name'=>"Cat3", 'date_of_birth'=>'2017-11-11', 'breed_id'=>3, 'created_at'=>'2017-09-18', 'updated_at'=>'2017-09-18'),
       )); 
      }
    }
