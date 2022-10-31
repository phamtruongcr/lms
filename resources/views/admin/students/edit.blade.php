@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Student Information</h3>
        </div>
        <!-- /.box-header -->

        <form action="{{route('student.update', $data->id)}}" method="post">
            <input name="_method" type="hidden" value="PUT">
            <div class="card-body row">
                {!! csrf_field() !!}
                <div class="col-md-6">
                    <div class="form-group @if($errors->has('first_name')) has-error @endif">
                        <label for="first_name" class="control-label">@lang('auth.form_user_fname_label') <span style="color: red">*</span></label>
                        <input type="text" name="first_name" class="form-control input-sm" placeholder="@lang('auth.form_user_fname_label')" value="{{ old('first_name') ?? $data->first_name }}" tabindex="1">
                        {!! $errors->first('first_name', '<em for="first_name" class="help-block">:message</em>') !!}
                    </div>

                    <div class="form-group @if($errors->has('phone')) has-error @endif">
                        <label for="phone" class="control-label">Phone<span style="color: red">*</span></label>
                        <input type="text" name="phone" class="form-control input-sm" placeholder="Phone" value="{{ old('phone') ?? $data->phone }}" tabindex="1">
                        {!! $errors->first('phone', '<em for="phone" class="help-block">:message</em>') !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group @if($errors->has('last_name')) has-error @endif">
                        <label for="last_name" class="control-label">@lang('auth.form_user_lname_label')</label>
                        <input type="text" name="last_name" class="form-control input-sm" placeholder="@lang('auth.form_user_lname_label')" value="{{ old('last_name') ?? $data->last_name }}" tabindex="2">
                        {!! $errors->first('last_name', '<em for="last_name" class="help-block">:message</em>') !!}
                    </div>

                    <div class="form-group @if($errors->has('birthday')) has-error @endif">
                        <label for="name" class="control-label">Date of birth<span style="color: red">*</span></label>
                        <input type="date" name="birthday" class="form-control input-sm" placeholder="@lang('auth.index_lname_th')" value="{{ old('birthday') ?? $data->birthday }}" tabindex="1">
                        {!! $errors->first('birthday', '<em for="birthday" class="help-block">:message</em>') !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group @if($errors->has('address')) has-error @endif">
                        <label for="name" class="control-label">Address <span style="color: red">*</span></label>
                        <input type="text" name="address" class="form-control input-sm" placeholder="Address" value="{{ old('address') ?? $data->address}}" tabindex="1">
                        {!! $errors->first('address', '<em for="address" class="help-block">:message</em>') !!}
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <label for="email" class="control-label">@lang('auth.form_user_email_label') <span style="color: red">*</span></label>
                        <input type="text" name="email" class="form-control input-sm" placeholder="user@risetproduk.com" value="{{ old('email') ?? $data->email }}" tabindex="3">
                        {!! $errors->first('email', '<em for="email" class="help-block">:message</em>') !!}
                    </div>

                 
            </div>
    </div>
    <div class="card-footer">
        <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
        <a href="{{route('student.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('auth.form_user_cancel_btn')</a>

        <div class="pull-right">
            <button type="submit" class="btn ladda-button btn-success btn-flat btn-sm" data-style="zoom-in">
                <span class="ladda-label"><i class="fa fa-save"></i> Save</span>
                <span class="ladda-spinner">
                    <div class="ladda-progress" style="width: 0px;"></div>
                </span></button>
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
            containerCssClass: ':all:',
        });
    });
</script>
@endpush