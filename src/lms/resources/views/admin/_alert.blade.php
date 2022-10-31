@if(session('success_msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Well done:</strong> {!! Session::get('success_msg') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error_msg'))
<div class="alert alert-error alert-dismissible fade show" role="alert">
        <strong>Warning:</strong> {!! Session::get('error_msg') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('warning_msg'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning:</strong> {!! Session::get('warning_msg') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif