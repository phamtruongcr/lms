@extends('layouts.app')
@section('title', 'lessons managerment')

@section('content')

<!-- Main content -->
<div class="row">
  <div class="col-12">
    @include('_alert')
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3>@lang('form/lesson.Lesson')</h3>
        <a href="{{route('lesson.create')}}" class="btn btn-flat btn-success btn-sm">@lang('form/lesson.Create')
        </a>
      </div>
      @if ($lesson)
      <div class="card-body">
        <h2>{{ $lesson->translate()->name }}</h2>
        <hr>
        <div>
          {!! $lesson->translate()->content !!}
        </div>
        <hr>
        <h4>File</h4>
        @if ($lesson->has('files'))
        @php
        $files = $lesson->files()->get()
        @endphp
        @foreach($files as $file)
        @if($file->type == 2)
        @php
        $div = explode('.', $file->path);
        $file_ext = strtolower(end($div));

        $div_name = explode('/', $file->path);
        $file_name = strtolower(end($div_name));

        $permited_ppt = array('ppt', 'pptx', 'pps', 'ppsx');
        $permited_doc = array('doc', 'docx');
        $permited_video = array('mp4', 'avi', 'mov', 'flv', 'wmv');

        if (in_array($file_ext, $permited_ppt) ){
        @endphp
        <a class="btn btn-outline-danger btn-file" href="{{ asset($file->path) }}" target="_blank"><i class="fas fa-file-powerpoint"></i> {{ $file_name }}</a>

        @php
        }

        if ( in_array($file_ext, $permited_doc) ){
        @endphp
        <a class="btn btn-outline-primary btn-file" href="{{ asset($file->path) }}" target="_blank"><i class="fas fa-file-word"></i> {{ $file_name }}</a>

        @php
        }

        if ( $file_ext == 'zip' ){
        @endphp
        <a class="btn btn-outline-warning btn-file" href="{{ asset($file->path) }}" target="_blank"><i class="fas fa-file-archive"></i> {{ $file_name }}</a>

        @php
        }

        if ( $file_ext == 'pdf' || in_array($file_ext, $permited_video) ){
        @endphp
        <iframe src="{{ asset($file->path) }}" width="100%" height="415px">
        </iframe>
        @php
        }
        @endphp
        @elseif($file->type == 1)
        @php
        $link = $file->path;
        $code = explode('=', $link);
        $link_youtube = end($code);
        @endphp
        <iframe src="https://www.youtube.com/embed/{{$link_youtube}}" width="100%" height="315px">
        </iframe>
        @endif
        <br>
        @endforeach
      </div>
      @endif
      @endif
      <!-- /.box-body -->
      <div class="card-footer clearfix">
        <a href="{{ route('lesson.edit', ['id'=>$lesson->id]) }}" class="btn btn-sm btn-success">
          <i class="fas fa-edit"></i> Edit
        </a>
        <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
        <a href="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" class="btn btn-flat btn-default btn-sm">
          <i class="fa fa-reply"></i>
          Cancel
        </a>
      </div>

    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- /.content -->
@stop