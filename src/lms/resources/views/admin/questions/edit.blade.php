@extends('layouts.app')
@section('title', ('form/question.Update'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">{{ __('form/question.Questions management') }}</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group me-2">
    <a class="btn btn-sm btn-primary" href="{{ route('question.create') }}">{{ __('form/question.Create a question') }}</a>
  </div>
</div>
</div>
<h2>{{ __('form/question.Update question') }} {{ $question->id }}</h2>
<div>
  <form method="post" action="{{ route('question.update', [$question->id]) }}"
  enctype="multipart/form-data">
    @include('admin/questions/_question_form')
  <button type="submit" class="btn btn-primary">{{ __('form/question.Save') }}</button>
  </form>
</div>
@stop

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
 
        ClassicEditor
            .create( document.querySelector( '#content' ) )
            .catch( error => {
                console.error( error );
            } );
        var otherlang=document.getElementById('other_language');
        var content_lang=document.getElementById('content_other_lang');
        otherlang.addEventListener('click', function(){
          content_lang.style.display='block';
          otherlang.style.display='none';
        });
        
    </script>
@stop