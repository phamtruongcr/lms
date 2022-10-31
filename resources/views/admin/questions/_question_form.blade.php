@csrf
<!-- form main -->
<div class="form-group">
    <label for="exampleFormControlSelect1">{{ __('form/question.Select the lesson') }}</label>
    <select class="form-control @error('lesson_id') is-invalid @enderror" id="exampleFormControlSelect1" name="lesson_id">
      <option value="">-</option>
      @forelse($lessons as $id => $name)
        @if ($id == old('lesson_id', $question->lesson_id))
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
  <label for="content">{{__('form/question.Question content') }}</label>
    <textarea name="content" id="content"
    class="form-control @error('content') is-invalid @enderror"
    rows="7">{{ old('content',$question->id ? $question->translate()->content:'') }}</textarea>
    @error('content')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputPoint">{{ __('form/question.Point') }}</label>
      <input type="" name="point" class="form-control @error('point') is-invalid @enderror"
       id="inputPoint"  value="{{ old('point',$question->point ? $question->point:'') }}">
      @error('point')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group col-md-4">
      <label for="inputType">{{ __('form/question.Type') }}</label>
      <select id="inputType" name="type" class="form-control @error('type') is-invalid @enderror">
        <option value="">-</option>
        @forelse($types as $value=> $name)
          @if ($value==old('type',$question->type))
          <option selected ="selected" value="{{ $value }}">{{ $name }}</option>
          @else
          <option value="{{ $value }}">{{ $name }}</option>
          @endif
        @empty
        @endforelse
      </select>
      @error('type')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group col-md-4">
      <label for="inputStatus">{{ __('form/question.Status') }}</label>
      <select id="inputStatus" name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="">-</option>
          @forelse($status as $value=> $name)
            @if ($value==old('type',$question->status))
            <option selected ="selected" value="{{ $value }}">{{ $name }}</option>
            @else
            <option value="{{ $value }}">{{ $name }}</option>
            @endif
          @empty
          @endforelse
      </select>
      @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
</div>
  
  <!-- form other language -->
<div id="content_other_lang" style="display:none;">
  <label for="content">{{__('form/question.Other question content') }}</label>
    <textarea name="other_content" id="content_2"
    class="form-control @error('other_content') is-invalid @enderror"
    rows="7">{{ old('other_content',$question->id ? $question->translate($other_language)->content:'') }}</textarea>
</div>
</div>
<!-- button add other language -->
<div id="other_language" class="btn btn-primary">
{{__('form/question.Create with other languages')}}
</div>

