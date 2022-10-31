@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')


<!-- Main content -->
<section class="content">
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Form add course for group</h3>

            <br>

        </div>


        <!-- /.card-header -->

        <form action="{{route('group.store')}}" method="post">
            <div class="card-body row">
                {!! csrf_field() !!}

                <div class="col-md-6">
                    <div class="form-group @if($errors->has('course')) has-error @endif">
                        <label for="group" class="control-label">Select group<span style="color: red">*</span></label>
                        <select name="group" class="form-control" data-placeholder="Select group" tabindex="4" style="width: 100%;">
                            
                            <option value="" {{ old('group') ? 'selected="selected"' : ''}}></option>
                            @foreach($groupDB as $group)
                            @if (old('group') == $group->id)
                            <option value="{{$group->id}}" selected="selected">{{$group->name}}</option>
                            @else
                            <option value="{{$group->id}}">{{$group->name}}</option>
                            @endif
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('course')) has-error @endif">
                            <label for="course" class="control-label">Select Course<span style="color: red">*</span></label>
                            <select name="course" class="form-control" data-placeholder="Select Course" tabindex="4" style="width: 100%;">
                                
                                <option value="" {{ old('course') ? 'selected="selected"' : ''}}></option>
                                @foreach($courseDB as $course)
                                @if (old('course') == $course->id)
                                <option value="{{$course->id}}" selected="selected">{{$course->name}}</option>
                                @else
                                <option value="{{$course->id}}">{{$course->name}}</option>
                                @endif
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6">
                        <div class="form-group @if($errors->has('teacher')) has-error @endif">
                            <label for="teacher" class="control-label">Select Teacher<span style="color: red">*</span></label>
                            <select name="teacher" class="form-control" data-placeholder="Select teacher" tabindex="4" style="width: 100%;">
                                
                                <option value="" {{ old('teacher') ? 'selected="selected"' : ''}}></option>
                                @foreach($teacherDB as $teacher)
                                @if (old('teacher') == $teacher->id)
                                <option value="{{$teacher->id}}" selected="selected">{{$teacher->first_name}}</option>
                                @else
                                <option value="{{$teacher->id}}">{{$teacher->first_name}}</option>
                                @endif
                                @endforeach
                            </select>

                        </div>

                        <div class="card-footer">
                            <input type="hidden" value="{{route('student.index')}}" name="previousUrl">
                            <a href="{{route('group.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('auth.form_user_cancel_btn')</a>

                            <div class="pull-right">
                                <button type="submit" class="btn btn-flat ladda-button btn-success btn-sm" data-style="zoom-in">
                                    <span class="ladda-label"><i class="fa fa-save"></i> Add</span>
                                    <span class="ladda-spinner">
                                        <div class="ladda-progress" style="width: 0px;"></div>
                                    </span>
                                </button>
                            </div>

                            <div class="clearfix"></div>
                        </div>
        </form>

    </div>
</section>
@endsection

@push('css')
<!-- Select 2 -->
<link rel="stylesheet" href="{{asset('adminLTE/plugins/select2/dist/css/select2.css')}}">
@endpush

@push('scripts')
<script src="{{asset('adminLTE/plugins/select2/dist/js/select2.full.js')}}"></script>

<script type="text/javascript">
    $(function() {
        $('form select').select2({
            theme: "bootstrap",
            placeholder: "Select",
            containerCssClass: ':all:'
        });
    });
</script>
@endpush