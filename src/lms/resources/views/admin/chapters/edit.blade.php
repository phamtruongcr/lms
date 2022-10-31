
@extends('layouts.app')
@section('title', __('form/chapter.chapters management'))

@section('content')
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('form/chapter.chapter')</h3>
        </div>
    
    <form action="{{route('chapter.update', ['id'=>$chapter->id])}}" method="post">
        <div class="card-body row">
        <!-- /.card-header -->
        @include('admin/chapters/_chapter_form')

        </div>

        <div class="card-footer">
            <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
            <a href="{{route('chapter.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> Cancel</a>

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
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" 
      data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Lesson delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('lesson.destroy_chapter_lesson') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="lesson_id" id="lesson_id" value="0">
        <input type="hidden" name="chapter_id" id="chapter_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this lesson?
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
</script>

<script>
  function lesson_delete (id, chapter_id)
  {
      var lesson_id = document.getElementById('lesson_id');
      var id_chapter = document.getElementById('chapter_id');
      lesson_id.value = id;
      id_chapter.value = chapter_id;
  }
</script>
@stop