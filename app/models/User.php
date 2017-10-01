<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
/*
class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 
	protected $hidden = array('password', 'remember_token');

}*/
//use Illuminate\Auth\UserInterface;
   class User extends Eloquent implements UserInterface, RemindableInterface{
     // use Authenticatable, CanResetPassword;
     public function getRememberToken()
     {    
        return $this->remember_token;
     }

     public function getReminderEmail()
     {
        return $this->email;
     }    

     public function setRememberToken($value)
     {
        $this->remember_token = $value;
     }

     public function getRememberTokenName()
     {
        return 'remember_token';
     }    

     public function getAuthIdentifier() {
       return $this->getKey();
     }
     public function getAuthPassword() {
       return $this->password;
     }
     public function cats(){
       return $this->hasMany('Cat');
     }
     public function owns(Cat $cat){
       return $this->id == $cat->owner;
     }
     public function canEdit(Cat $cat){
       return $this->is_admin or $this->owns($cat);
     }
}
