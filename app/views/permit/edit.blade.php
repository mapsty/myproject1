@extends('master')
   @section('header')
     <a href="{{url('cats')}}">&larr; Cancel </a>
     <h2>
         @if($method == 'post')
           Add a new cat
         @elseif($method == 'delete')
           Delete {{$cat->name}}?
         @else
           Edit {{$cat->name}}
         @endif
         
     </h2>
      
@stop

@section('content')
     {{Form::model($cat, array('method' => $method, 'url'=>
     'cats/'.$cat->id))}}
     @unless($method == 'delete')
       
         @if ( $errors->count() > 0 )
      <p>The following errors have occurred:</p>

      <ul>
        @foreach( $errors->all() as $message )
          <li>{{ $message }}</li>
        @endforeach
      </ul>
         @endif

         <div class="form-group">
         {{Form::label('Name')}}
         {{Form::text('name')}}
       </div>
       <div class="form-group">
         {{Form::label('Date of birth')}}
         {{Form::text('date_of_birth')}}
       </div>
       <div class="form-group">
         {{Form::label('Breed')}}
         {{Form::select('breed_id', $breed_options)}}
       </div>
       <div class="form-group">
         {{Form::label('Cat')}}
         {{Form::select('cat_id', $cat_options)}}
       </div>
       {{Form::submit("Save", array("class"=>"btn btn-default"))}}
     @else
       {{Form::submit("Delete", array("class"=>"btn btn-default"))}}
     @endif
   {{Form::close()}}
@stop
