
@extends('layouts.app')
@section('title', __('form/chapter.chapters management'))

@section('content')
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Chapter</h3>
        </div>
    
    <form action="{{route('chapter.store')}}" method="post">
        <div class="card-body row">
        <!-- /.card-header -->
        @include('admin/chapters/_chapter_form')

        </div>

        <div class="card-footer">
            <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
            <a href="{{route('chapter.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> Cancel</a>

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
</script>
@stop