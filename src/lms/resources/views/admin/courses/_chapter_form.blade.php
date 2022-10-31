@csrf

<div class="col-md-12">

  <div class="form-group">
    <label for="name" class="control-label">Name chapter <span style="color: red">*</span> </label>
    <input type="text" class="form-control input-sm @error('name') is-invalid @enderror" placeholder="Name chapter"
    value="{{ old('name', '') }}" name="name">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  
  <div class="form-group">
    <label for="description" class="control-label">Description</label>
    <textarea name="description" id="summernote"
    class="form-control @error('description') is-invalid @enderror"
    rows="7">{{ old('description', '') }}</textarea>
    @error('description')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="start_at" class="control-label">Start</label>
    <input type="date" class="form-control input-sm @error('start_at') is-invalid @enderror"
    value="{{ old('start_at', '') }}" name="start_at">
    @error('start_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="finish_at" class="control-label">Finish</label>
    <input type="date" class="form-control input-sm @error('finish_at') is-invalid @enderror"
    value="{{ old('start_at', '') }}" name="finish_at">
    @error('finish_at')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-md-12">

  <div class="form-group">
    <label class="control-label" for="lesson_ids">Select the Lesson</label>
    <select class="form-control selectpicker form-select @error('lesson_ids') is-invalid @enderror" 
      name="lesson_ids[]" multiple> 
      @forelse($lessons as $id=>$name) 
        <option value="{{$id}}" >{{$name}}</option>
      @empty
      @endforelse
    </select>
    @error('lesson_ids')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

            