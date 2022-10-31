@extends('layouts.app')
@section('title',('form/answer.Create a answer'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Answers management</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group me-2">
    <a class="btn btn-sm btn-primary" href="{{ route('answer.create') }}">{{__('form/answer.Create a answer') }}</a>
  </div>
</div>
</div>
<h2>{{__('form/answer.Create a answer') }}</h2>
<div>
  <form method="post" action="{{ route('answer.store') }}">
  @include('admin/answers/_answer_form')
  <button type="submit" class="btn btn-primary">{{__('form/answer.Create') }}</button>
  </form>
</div>
@stop

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
        ClassicEditor
            .create( document.querySelector( '#description' ) )
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