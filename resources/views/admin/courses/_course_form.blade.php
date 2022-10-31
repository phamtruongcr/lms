@csrf

<div class="col-md-12">

  <div class="form-group">
    <label for="name" class="control-label">Name course <span style="color: red">*</span> </label>
    <input type="text" class="form-control input-sm @error('name') is-invalid @enderror" placeholder="Name course"
    value="{{ old('name', $course->translate()->name??'') }}" name="name">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="description" class="control-label">Description <span style="color: red">*</span> </label>
    <textarea name="description" id="summernote"
    class="form-control @error('description') is-invalid @enderror"
    rows="7">{{ old('description', $course->translate()->description??'') }}</textarea>
    @error('description')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="start_at" class="control-label">Start <span style="color: red">*</span> </label>
    <input type="date" class="form-control input-sm @error('start_at') is-invalid @enderror"
    value="{{ old('start_at', $course->start_at??'') }}" name="start_at">
    @error('start_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="finish_at" class="control-label">Finish <span style="color: red">*</span> </label>
    <input type="date" class="form-control input-sm @error('finish_at') is-invalid @enderror"
    value="{{ old('start_at', $course->finish_at??'') }}" name="finish_at">
    @error('finish_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-md-12">
  <div class="form-group">
    <label for="image" class="control-label">Photo</label>

    @if ($course->has('image'))
    @php
    $images = $course->image()->get()
    @endphp
    @foreach($images as $image)
    <br>
    <img src="{{ asset($image->name) }}" class="img-thumbnail" alt="" style="width: 300px; height: 200px;">
    @endforeach
    @endif

    <input type="file" class="form-control input-sm" name="photo" id="image">
  </div>
  <img id="image_view" src="#" alt="course image" style="width: 300px; height: 200px;"/>
</div>

            