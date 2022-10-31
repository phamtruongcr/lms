@extends('layouts.app')
@section('title','Create a Class')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Classes management</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group me-2">
    <a class="btn btn-sm btn-primary" href="{{ route('student.addstudent') }}">Create a class</a>
  </div>
</div>
</div>
<h2>Create a class</h2>
<div>
  <form method="post" action="{{ route('student.storestudent') }}">
  @csrf
  <div class="form-group">
    <label for="class_name" class="control-label">Class name <span style="color: red">*</span> </label>
    <input type="text" class="form-control input-sm @error('class_name') is-invalid @enderror" placeholder="Name class"
    value="{{ old('class_name', $class->name??'') }}" name="class_name" id="class_name">
    @error('class_name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
      <label for="list_students">List students</label>
      <select id="list_students" name="list_students" class="form-control" data-live-search="true" multiple >
        <option value="">-</option>
        @forelse($students as $mail=>$id)
        <option value="{{$id }}">{{ $mail }}</option>
        @empty
        @endforelse
      </select>
  </div>
  <div class="form-group">
      <label for="class_manager">Class manager</label>
      <select id="class_manager" name="class_manager" class="form-control" >
        <option value="">-</option>
        @forelse($managers as $mail=>$id)
        <option value="{{$id }}">{{ $mail }}</option>
        @empty
        @endforelse
      </select>
  </div>
  <input type="hidden" name="students" id="list_stus"value="">
  <button type="submit" class="btn btn-primary">Create</button>
  </form>
</div>
@stop

@section('js')
<script>
    $('#list_students').selectpicker();
    $('#list_students').on('change', function(){
        let list_student=$('#list_students').val();
        $('#list_stus').val(list_student.toString());
    })
    </script>
@stop