
@extends('layouts.app')
@section('title', __('form/lesson.lessons management'))

@section('content')
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('form/lesson.Lesson')</h3>
        </div>
    
    <form action="{{route('lesson.store')}}" method="post" enctype="multipart/form-data">
        <div class="card-body row">
        <!-- /.card-header -->
        @include('admin/lessons/_lesson_form')

        </div>

        <div class="card-footer">
            <a href="{{route('lesson.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> Cancel</a>

            <div class="pull-right">
                <button type="submit" class="btn btn-flat ladda-button btn-success btn-sm" data-style="zoom-in">
                <span class="ladda-label"><i class="fa fa-save"></i> Create</span>
                    <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span>
                </button>
            </div>

            <div class="clearfix"></div>
        </div>

    </form>
</div>

@stop

@section('js')
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })

  var btn_youtube=document.getElementById('youtube');
  var link_youtube=document.getElementById('link_form_youtube');
  btn_youtube.addEventListener('click', function(){
    link_youtube.style.display='block';
    btn_youtube.style.display='none';
  });
</script>
@stop