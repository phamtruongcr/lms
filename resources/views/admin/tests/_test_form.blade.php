@csrf
<!-- form main -->
<div class="form-group">
    <label for="exampleFormControlSelect1">{{ __('form/test.Select the lesson') }}<span style="color: red">*</span></label>
    <select class="form-control @error('lesson_id') is-invalid @enderror" id="exampleFormControlSelect1" name="lesson_id">
      <option value="">-</option>
      @forelse($lessons as $id => $name)
        @if ($id == old('lesson_id', $test->lesson_id))
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
    <label for="name" class="control-label">{{ __('form/test.Name test') }} <span style="color: red">*</span> </label>
    <input type="text" class="form-control input-sm @error('name') is-invalid @enderror" placeholder="Name test"
    value="{{ old('name', $test->translate()->name??'') }}" name="name">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
  <label for="description">{{__('form/test.Test description') }}</label>
    <textarea name="description" id="description"
    class="form-control"
    rows="7">{{ old('description', $test->translate()->description??'') }}</textarea>
</div>
<div class="form-row">
    <div class="form-group col-md-3">
      <label for="total_point">{{ __('form/test.Total point') }}</label>
      <input type="" name="total_point" class="form-control @error('total_point') is-invalid @enderror"
       id="total_point"  value="{{ old('total_point',$test->total_point ? $test->total_point:'') }}">
    </div>
    <div class="form-group col-md-3">
      <label for="total_time">{{ __('form/test.Total time') }}<span style="color: red">*</span></label>
      <input type="number" name="total_time" class="form-control @error('total_time') is-invalid @enderror"
       id="total_time"  value="{{ old('total_time',$test->total_time ? $test->total_time:'') }}">
      @error('total_time')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group col-md-3">
      <label for="limit">{{ __('form/test.Limit') }}</label>
      <input type="number" name="limit" class="form-control @error('limit') is-invalid @enderror"
       id="limit"  value="{{ old('limit',$test->limit ? $test->limit:'') }}">
      @error('limit')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-group col-md-3">
      <label for="status">{{ __('form/test.Status') }}</label>
      <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="">-</option>
          @forelse($status as $value=> $name)
            @if ($value==old('type',$test->status))
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
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="test_category">{{ __('form/test.Select the category') }}</label>
        <select class="form-control" id="test_category" name="test_category" data-live-search="true">
          <option value="">-</option>
          @forelse($lessons as $id => $name)
            @if ($id == old('lesson_id', $test->lesson_id))
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
    
    <div class="form-group col-md-8">
      <label for="test_questions">{{ __('form/test.Questions') }}</label>
      <select id="test_questions" name="test_questions" class="form-control" data-live-search="true" >
        <option value="">-</option>
      </select>
    </div>
</div>

<div class="card-body">
                
  <table class="table table-bordered table-hover table-striped" id="table_questions">
      <thead>
      <tr>
          <th>#</th>
          <th scope='col'>@lang('form/test.Name questions')</th>
          <th scope='col'>@lang('form/test.Point')</th>
          <th scope='col'>@lang('form/test.Type')</th>
          <th scope='col'>@lang('form/test.Action')</th>
      </tr>
      </thead>
      <tbody id='preview_questions'>
      @if ($test->has('questions'))
        @php
        $questions = $test->questions()->get()
        @endphp
        @foreach($questions as $question)
        <tr data-point="{{ $question->point}}" data-id="{{ $question->id }}">
          <td></td>
          <td>{{ $question->translate()->content }}</td>
          <td>{{ $question->point }}</td>
          <td>{{ $question->type }}</td>
          <td>
            <div class="delete_pre_question" onclick="deleteRow(this)">
                   <i class="fas fa-minus-circle text-danger"></i>
            </div>
          </td>
        </tr>
        @endforeach
      @endif
      </tbody>
  </table>
</div>
<input type='hidden' id="list_question_id" name='list_question_id' value=''>
                <!-- /.box-body -->
  <!-- form other language -->
  <div id="form_other_lang" style="display: none;">
    <div class="form-group">
      <label for="other_name" class="control-label">{{ __('form/test.Name test with other languages') }} </label>
      <input type="text" class="form-control input-sm " placeholder="Name test"
      value="{{ old('other_name', $test->translate($other_language)->name??'') }}" name="other_name">
    </div>
    <div class="form-group">
    <label for="other_description">{{__('form/test.Test description with other languages') }}</label>
      <textarea name="other_description" id="other_description"
      class="form-control"
      rows="7">{{ old('other_description',$test->translate($other_language)->description??'') }}</textarea>
    </div>

  </div>
  
<!-- button add other language -->
<div id="btn_other_language" class="btn btn-primary">
{{__('form/test.Create with other languages')}}
</div>

