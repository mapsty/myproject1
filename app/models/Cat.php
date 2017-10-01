<?php
/*Original
class Cat extends Eloquent {
     protected $fillable = array('name','date_of_birth','breed_id');
     public function breed(){
       return $this->belongsTo('Breed');
     }
 }*/



class Cat extends Eloquent {
     protected $fillable = array('name','date_of_birth','breed_id');
     public static function validate($input) {

        $rules = array(
                'name' => 'Required|Min:3|Max:80|Alpha',
        );

        return Validator::make($input, $rules);
     }
     public function breed(){
       return $this->belongsTo('Breed');
     }
 }
