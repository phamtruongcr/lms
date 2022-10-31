@csrf
<!-- form main -->
<div class="form-group">
    <label for="exampleFormControlSelect1">Select the lesson</label>
    <select class="form-control @error('lesson_id') is-invalid @enderror" id="exampleFormControlSelect1" name="lesson_id">
      <option value="">-</option>
      @forelse($lessons as $id => $name)
        @if ($id == old('lesson_id', $answer->lesson_id))
        <option selected="selected" value="{{ $id }}">{{ $name }}</option>
        @else
        <option value="{{ $id }}">{{ $name }}</option>
        @endif
      @empty
      @endforelse
    </select>
    @error('lesson_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
  <label for="content">{{__('form/answer.Answer content') }}</label>
    <textarea name="content" id="content"
    class="form-control @error('content') is-invalid @enderror"
    rows="7">{{ old('content',$answer->id ? $answer->translate()->content:'') }}</textarea>
    @error('content')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
  
  <!-- form other language -->
<div id="content_other_lang" style="display:none;">
  <label for="content">{{__('form/answer.Other answer content') }}</label>
    <textarea name="other_content" id="content_2"
    class="form-control @error('other_content') is-invalid @enderror"
    rows="7">{{ old('other_content',$answer->id ? $answer->translate($other_language)->content:'') }}</textarea>
</div>
</div>
<!-- button add other language -->
<div id="other_language" class="btn btn-primary">
{{__('form/answer.Create with other languages')}}
</div>

