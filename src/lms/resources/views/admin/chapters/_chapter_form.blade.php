@csrf

<div class="col-md-12">

  <div class="form-group">
    <label for="name" class="control-label">Name chapter <span style="color: red">*</span> </label>
    <input type="text" class="form-control input-sm @error('name') is-invalid @enderror" placeholder="Name chapter"
    value="{{ old('name', $chapter->translate()->name??'') }}" name="name">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="control-label" for="course_id">Select the Course <span style="color: red">*</span> </label>
    <select class="form-control form-select @error('course_id') is-invalid @enderror" 
      name="course_id">
      <option value="" >-</option>  
      @forelse($courses as $id=>$name) 
        @if(old('course_id', $chapter->course_id) == $id)
          <option value="{{$id}}" selected>{{$name}}</option>
        @else
        <option value="{{$id}}" >{{$name}}</option>
        @endif
      @empty
      @endforelse
    </select>
    @error('course_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="description" class="control-label">Description</label>
    <textarea name="description" id="summernote"
    class="form-control @error('description') is-invalid @enderror"
    rows="7">{{ old('description', $chapter->translate()->description??'') }}</textarea>
    @error('description')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="start_at" class="control-label">Start</label>
    <input type="date" class="form-control input-sm @error('start_at') is-invalid @enderror"
    value="{{ old('start_at', $chapter->start_at??'') }}" name="start_at">
    @error('start_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="finish_at" class="control-label">Finish</label>
    <input type="date" class="form-control input-sm @error('finish_at') is-invalid @enderror"
    value="{{ old('start_at', $chapter->finish_at??'') }}" name="finish_at">
    @error('finish_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

@php
$chapter_ids = []
@endphp
@if ($chapter->has('lessons'))
@php
$chapter_lessons = $chapter->lessons()->get()
@endphp
@if( count($chapter_lessons)!=0 )
<div class="col-12">
<label>Lesson</label>
<div class="card">
  <div class="card-body table-responsive p-0" style="height: 400px;">
    <table id="example1" class="table table-bordered table-striped table-head-fixed">
    <thead>
    <tr>
      <th>@lang('form/lesson.Name lesson')</th>
      <th>@lang('form/lesson.Create at')</th>
      <th>@lang('form/lesson.Update at')</th>
      <th>@lang('form/lesson.Action')</th>
    </tr>
    </thead>
    <tbody>
@foreach($chapter_lessons as $lesson)
  @php
  $chapter_ids[] = $lesson->id
  @endphp
  <tr>
      <td>
      <a href="{{route('lesson.detail', ['slug'=>$lesson->slug])}}">
      {{ $lesson->translate()->name }}
      </a>
      </td>
      <td>{{ $lesson->created_at->format('d-m-Y') }}</td>
      <td>{{ $lesson->updated_at->format('d-m-Y') }}</td>
      <td>
        <h4>
          <a class="text-danger" data-toggle="modal" 
              data-target="#deleteModal" onclick="javascript:lesson_delete('{{ $lesson->id }}', '{{ $chapter->id }}')">
            <i class="fas fa-minus-circle"></i>
          </a>
        </h4>  
      </td>
  </tr>
@endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif
@endif

<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="lesson_ids">Select the Lesson</label>
    <select class="form-control selectpicker form-select @error('lesson_ids') is-invalid @enderror" 
      name="lesson_ids[]" multiple> 
      @forelse($lessons as $id=>$name) 
        @if( !in_array($id, $chapter_ids) )
          <option value="{{$id}}" >{{$name}}</option>
        @endif
      @empty
      @endforelse
    </select>
    @error('lesson_ids')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

            