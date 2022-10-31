@extends('layouts.app')

@section('content')

    <!-- Main content -->
    @include('_alert')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">@lang('auth.index_users')</h3>
        </div>
        <!-- /.card-header -->

        <form action="{{route('users.store')}}" method="post">
            <div class="card-body row">
                {!! csrf_field() !!}

                <div class="col-md-6">
                    <div class="form-group @if($errors->has('first_name')) has-error @endif">
                        <label for="name" class="control-label">@lang('auth.index_fname_th') 
                            <span style="color: red">*</span>
                        </label>
                        <input type="text" name="first_name" 
                        class="form-control input-sm" 
                        placeholder="@lang('auth.index_fname_th')" value="{{ old('first_name') }}" tabindex="1">
                        {!! $errors->first('first_name', '<em for="first_name" class="help-block">:message</em>') !!}
                    </div>

                    <div class="form-group @if($errors->has('phone')) has-error @endif">
                        <label for="phone" class="control-label">Phone 
                            <span style="color: red">*</span>
                        </label>
                        <input type="text" name="phone" 
                        class="form-control input-sm" 
                        placeholder="Phone" value="{{ old('phone') }}" tabindex="1">
                        {!! $errors->first('phone', '<em for="phone" class="help-block">:message</em>') !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group @if($errors->has('last_name')) has-error @endif">
                        <label for="name" class="control-label">@lang('auth.index_lname_th') <span style="color: red">*</span></label>
                        <input type="text" name="last_name" class="form-control input-sm" placeholder="@lang('auth.index_lname_th')" value="{{ old('last_name') }}" tabindex="1">
                        {!! $errors->first('last_name', '<em for="last_name" class="help-block">:message</em>') !!}
                    </div>
                    
                    <div class="form-group @if($errors->has('birthday')) has-error @endif">
                        <label for="name" class="control-label">{{ __('form/register.Date of birth')}} <span style="color: red">*</span></label>
                        <input type="date" name="birthday" class="form-control input-sm" placeholder="@lang('auth.index_lname_th')" value="{{ old('birthday') }}" tabindex="1">
                        {!! $errors->first('birthday', '<em for="birthday" class="help-block">:message</em>') !!}
                    </div>
                </div>
                <div class="col-md-12">
                <div class="form-group @if($errors->has('address')) has-error @endif">
                        <label for="name" class="control-label">Address <span style="color: red">*</span></label>
                        <input type="text" name="address" class="form-control input-sm" placeholder="Address" value="{{ old('address') }}" tabindex="1">
                        {!! $errors->first('address', '<em for="address" class="help-block">:message</em>') !!}
                </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <label for="email" class="control-label">@lang('auth.form_user_email_label') <span style="color: red">*</span></label>
                        <input type="text" name="email" class="form-control input-sm" placeholder="user@dhanhost.com" value="{{ old('email') }}" tabindex="3">
                        {!! $errors->first('email', '<em for="email" class="help-block">:message</em>') !!}
                    </div>

                    <div class="form-group @if($errors->has('password')) has-error @endif">
                        <label for="password" class="control-label">@lang('auth.form_user_password_label') <span style="color: red">*</span></label>
                        <input type="password" name="password" class="form-control input-sm" placeholder="@lang('auth.form_user_password_label')" value="{{old('password')}}" tabindex="5">
                        <span class="help-block margin-top-sm">{{trans('auth.form_user_password_long')}}</span>
                        {!! $errors->first('password', '<em for="password" class="help-block">:message</em>') !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group @if($errors->has('role')) has-error @endif">
                        <label for="role" class="control-label">@lang('auth.form_user_role_label') <span style="color: red">*</span></label>

                        <select name="role" class="form-control" data-placeholder="@lang('auth.form_user_role_select')" tabindex="4" style="width: 100%;">

                            <option value="" {{ old('role') ? 'selected="selected"' : ''}}></option>
                            @foreach($roleDb as $role)
                                @if (old('role') == $role->id)
                                    <option value="{{$role->id}}" selected="selected">{{$role->name}}</option>
                                @else
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        {!! $errors->first('role', '<em for="role" class="help-block">:message</em>') !!}

                    </div>

                    <div class="form-group @if($errors->has('password')) has-error @endif">
                        <label for="password_confirmation" class="control-label">@lang('auth.form_user_password_confirm_label') <span style="color: red">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control input-sm" placeholder="@lang('auth.form_user_password_confirm_label')" value="{{old('password_confirmation')}}" tabindex="6">
                        <span class="help-block margin-top-sm">@lang('auth.form_user_password_type_again')</span>
                        {!! $errors->first('password', '<em for="password" class="help-block">:message</em>') !!}
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{route('users.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('auth.form_user_cancel_btn')</a>

                <div class="pull-right">
                    <button type="submit" class="btn btn-flat ladda-button btn-success btn-sm" data-style="zoom-in">
                    <span class="ladda-label"><i class="fa fa-save"></i> @lang('auth.form_user_submit_btn')</span>
                        <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span>
                    </button>
                </div>

                <div class="clearfix"></div>
            </div>

        </form>
    </div>
@endsection

@push('css')
<!-- Select 2 -->
<link rel="stylesheet" href="{{asset('adminLTE/plugins/select2/dist/css/select2.css')}}">
@endpush

@push('scripts')
<script src="{{asset('adminLTE/plugins/select2/dist/js/select2.full.js')}}"></script>

<script type="text/javascript">
    $(function () {
        $('form select').select2({
            theme: "bootstrap",
            placeholder: "Select",
            containerCssClass: ':all:'
        });
    });
</script>
@endpush