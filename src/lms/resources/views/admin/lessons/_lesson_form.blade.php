@csrf

<div class="col-md-12">

  <div class="form-group">
    <label for="name" class="control-label">@lang('form/lesson.Name lesson') <span style="color: red">*</span> </label>
    <input type="text" class="form-control input-sm @error('name') is-invalid @enderror" placeholder="@lang('form/lesson.Name lesson')"
    value="{{ old('name', $lesson->translate()->name??'') }}" name="name">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="content" class="control-label">@lang('form/lesson.Content')</label>
    <textarea name="content" id="summernote"
    class="form-control @error('content') is-invalid @enderror"
    rows="7">{{ old('content', $lesson->translate()->content??'') }}</textarea>
    @error('content')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

</div>

<div class="col-md-12">
  <div class="form-group">
  <label for="files" class="control-label">@lang('form/lesson.File')</label>
    @if ($lesson->has('files'))
      @php
      $files = $lesson->files()->get()
      @endphp
      @foreach($files as $file)
        @if($file->type == 2)  
        <br> 
        <a href="{{ $file->path }}" target="_blank">
        @php
          $div_name = explode('/', $file->path);
          $file_name = strtolower(end($div_name));
        @endphp
        {{ $file_name }}
        </a>
        <a class="text-danger" style="margin-left: 10px;" data-toggle="modal" data-target="#deleteModal" 
            onclick="javascript:lesson_delete('{{ $file->id }}')"><i 
            class="fas fa-times"></i></a>
        @elseif($file->type == 1)
          @php
          $link_youtube = $file->path
          @endphp
        @endif
      @endforeach
    @endif
    <input type="file" name="files[]" class="form-control-file" multiple>
    @error('files.*')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  @if(isset($link_youtube))
  <div class="form-group" id="link_form_youtube">
  @else
  <div class="btn btn-success" id="youtube">
    Youtube
  </div>
  <div class="form-group" style="display: none;" id="link_form_youtube">
  @endif
      <label for="link_youtube" class="control-label">@lang('form/lesson.Youtube')</label>
      <input type="text" class="form-control input-sm @error('link_youtube') is-invalid @enderror" placeholder="Link youtube"
      value="{{ old('link_youtube', isset($link_youtube)? $link_youtube :'' )}}" name="link_youtube">
      @error('link_youtube')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
  </div>
</div>

            