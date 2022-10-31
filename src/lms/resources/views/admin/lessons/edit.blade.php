
@extends('layouts.app')
@section('title', __('form/lesson.lessons management'))

@section('content')
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('form/lesson.Lesson')</h3>
        </div>
    
    <form action="{{route('lesson.update', ['id'=>$lesson->id])}}" method="post" enctype="multipart/form-data">
        <div class="card-body row">
        <!-- /.card-header -->
        @include('admin/lessons/_lesson_form')

        </div>

        <div class="card-footer">
            <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
            <a href="{{route('lesson.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> Cancel</a>

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

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">File delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('file.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="file_id" id="file_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this file?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-danger">Yes</button>
      </div>
      </form>
    </div>
  </div>
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

  function lesson_delete (id)
  {
      var file_id = document.getElementById('file_id');
      file_id.value = id;
  }

  var btn_youtube=document.getElementById('youtube');
  var link_youtube=document.getElementById('link_form_youtube');
  btn_youtube.addEventListener('click', function(){
    link_youtube.style.display='block';
    btn_youtube.style.display='none';
  });
</script>
@stop