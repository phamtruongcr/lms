
@extends('layouts.app')
@section('title', __('form/course.courses management'))

@section('content')
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('form/course.Course')</h3>
        </div>
    
    <form action="{{route('course.update', ['id'=>$course->id])}}" method="post" enctype="multipart/form-data">
        <div class="card-body row">
        <!-- /.card-header -->
        @include('admin/courses/_course_form')

        </div>

        <div class="card-footer">
            <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
            <a href="{{route('course.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> Cancel</a>

            <div class="pull-right">
                <button type="submit" class="btn btn-flat ladda-button btn-success btn-sm" data-style="zoom-in">
                <span class="ladda-label"><i class="fa fa-save"></i> Update</span>
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

  $('#image_view').hide();

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
        $('#image_view').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
   
    }
    $("#image").change(function() {
    readURL(this);
    $('#image_view').show();
    });
</script>
@stop