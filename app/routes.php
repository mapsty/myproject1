<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
i It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*
Route::get('/', function()
{
	return View::make('hello');
});
*/

Route::get('login', function(){
     return View::make('login');
});

Route::post('login', function(){
     if(Auth::attempt(Input::only('username', 'password'))) {
       return Redirect::intended('/');
     } else {
     return Redirect::back()
       ->withInput()
       ->with('error', "Invalid credentials");
     }
});

Route::get('logout', function(){
     Auth::logout();
     return Redirect::to('/')
       ->with('message', 'You are now logged out');
});

Route::model('cat', 'Cat');

Route::get('/', function(){
     return Redirect::to('cats');
});
/* original get cats
Route::get('cats', function(){
     $cats = Cat::all();
     return View::make('cats.index')
       ->with('cats', $cats);
});*/
/* move to group
Route::get('cats', function(){
     $cats = Cat::where('user_id', Auth::user()->id)->get();
     return View::make('cats.index')
       ->with('cats', $cats);
});*/

/*
Route::get('cats/{id}', function($id) {
     $cat = Cat::find($id);
     return View::make('cats.single')
       ->with('cat', $cat);
});*/

Route::get('permit', function(){
     $cats = Cat::all();
     return View::make('permit.index')
       ->with('cats', $cats);
});

Route::get('permit/{id}', function($id) {
     $cat = Cat::find($id);
     return View::make('permit.single')
       ->with('cat', $cat);
});

Route::get('permit/{cat}/edit', function(Cat $cat) {
     return View::make('permit.edit')
       ->with('cat', $cat)
       ->with('method', 'put');
});

Route::group(array('before'=>'auth'), function(){
Route::get('cats', function(){
     $cats = Cat::where('user_id', Auth::user()->id)->get();
     return View::make('cats.index')
       ->with('cats', $cats);
});
Route::get('cats/create', function() {
     $cat = new Cat;
     return View::make('cats.edit')
       ->with('cat', $cat)
       ->with('method', 'post');
});
/*original post - 20170922
Route::post('cats', function(){
     $cat = Cat::create(Input::all());
     $cat->user_id = Auth::user()->id; 
     if($cat->save()){
     return Redirect::to('cats/' . $cat->id)
       ->with('message', 'Successfully created page!');
     } else {
       return Redirect::back()
         ->with('error', 'Could not create profile');
     } 
});*/

Route::post('cats', function(){
     $validation_result = Cat::validate(Input::all());
     //$validation_result = Validator::make($rules, Input::all());
     if($validation_result->passes())
     {
     $cat = Cat::create(Input::all());
     $cat->user_id = Auth::user()->id; 
     if($cat->save()){
     return Redirect::to('cats/' . $cat->id)
       ->with('message', 'Successfully created page!');
     } else {
       return Redirect::back()
         ->with('error', 'Could not create profile');
     } }else{
      /*return Redirect::back()
     ->with('messages', $validation_result->messages());*/
        return Redirect::to('/cats/create')->withErrors($validation_result->Messages());
        }
});

});

Route::get('cats/{cat}/edit', function(Cat $cat) {
     return View::make('cats.edit')
       ->with('cat', $cat)
       ->with('method', 'put');
});

Route::get('cats/{cat}/delete', function(Cat $cat) {
     return View::make('cats.edit')
       ->with('cat', $cat)
       ->with('method', 'delete');
});
/*
Route::post('cats', function(){
     $cat = Cat::create(Input::all());
     return Redirect::to('cats/' . $cat->id)
       ->with('message', 'Successfully created page!');
});*/
 
Route::put('cats/{cat}', function(Cat $cat) {
     if(Auth::user()->canEdit($cat) and $cat->user_id === Auth::user()->id){
     $cat->update(Input::all());
     return Redirect::to('cats/' . $cat->id)
       ->with('message', 'Successfully updated page!');
     } else {
       return Redirect::to('cats/' . $cat->id)
         ->with('error', "Unauthorized operation");
       }
});

Route::delete('cats/{cat}', function(Cat $cat) {
     $cat->delete();
     return Redirect::to('cats')
       ->with('message', 'Successfully deleted page!');
});

Route::get('cats/{id}', function($id) {
     $cat = Cat::find($id);
     return View::make('cats.single')
       ->with('cat', $cat);
});

Route::get('cats/breeds/{name}', function($name){
     $breed = Breed::whereName($name)->with('cats')->first();
     return View::make('cats.index')
       ->with('breed', $breed)
       ->with('cats', $breed->cats);
});

Route::get('about', function(){
     return View::make('about')->with('number_of_cats', 9000);
});
/*
Route::get('cats/{id}', function($id){
     return "Cat #$id";
})->where('id', '[0-9]+');*/

View::composer('cats.edit', function($view)
   {
     $breeds = Breed::all();
     if(count($breeds) > 0){
       $breed_options = array_combine($breeds->lists('id'),
                                    $breeds->lists('name'));
     } else {
       $breed_options = array(null, 'Unspecified');
       }    
     $view->with('breed_options', $breed_options);
   });

View::composer('permit.edit', function($view)
   {
     $breeds = Breed::all();
     if(count($breeds) > 0){
       $breed_options = array_combine($breeds->lists('id'),
                                    $breeds->lists('name'));
     } else {
       $breed_options = array(null, 'Unspecified');
       }
     $view->with('breed_options', $breed_options);

     $cats = Cat::all();
     if(count($cats) > 0){
       $cat_options = array_combine($cats->lists('id'),
                                    $cats->lists('permit'));
     } else {
       $cat_options = array(null, 'Unspecified');
       }
     $view->with('cat_options', $cat_options);
   });
