@extends('layouts.app')
@section('title', 'Users managerment')

@section('content')

        <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-12">
            @include('_alert')
        </div>

        <div class="col-12">
        <div class="card">
        <div class="card-header">
          <h3 class="box-title">@lang('auth.index_users')</h3>
          <a href="{{route('users.create')}}" 
          class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
        </div>
        <div class="table table-bordered table-hover">
            
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('auth.index_fname_th')</th>
                        <th>@lang('auth.index_lname_th')</th>
                        <th>@lang('auth.index_email_th')</th>
                        <th>@lang('auth.index_roles')</th>
                        <th>@lang('auth.index_last_login')</th>
                        <th>@lang('auth.index_status_th')</th>
                        <th>@lang('auth.index_created_at')</th>
                        <th>@lang('auth.index_updated_at')</th>
                        <th>@lang('auth.index_action_th')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() -1) * $users->perPage() }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                        @if ($user->roles->isNotEmpty())
                        {{ implode(', ', collect($user->roles)->pluck('name')->all()) }}
                        @endif
                        </td>
                        <td>{{ $user->last_login }}</td>
                        <td>
                          @if ($user->activations->isNotEmpty())
                                @if ($user->activations[0]->completed == 1)
                                    <a href="#" data-message="{{ __('auth.deactivate_subheading', ['name' => $user->email]) }}"
                                    data-href="{{ route('users.status', $user->id) }}" id="tooltip"
                                    data-method="PUT" data-title="{{ __('auth.deactivate_this_user') }}"
                                    data-title-modal="{{ __('auth.deactivate_heading') }}"
                                    data-toggle="modal" data-target="#delete" title="{{ __('auth.deactivate_this_user') }}">
                                    <span class="label label-success label-sm">{{ __('auth.index_active_link') }}</span></a>
                                @endif
                          @else
                              <a href="#" data-message="{{ __('auth.activate_subheading', ['name' => $user->email]) }}"
                              data-href="{{ route('users.status', $user->id) }}"
                              id="tooltip" data-method="PUT" data-title="{{ __('auth.activate_this_user') }}"
                              data-title-modal="{{ __('auth.deactivate_heading') }}"
                              data-toggle="modal" data-target="#delete" title="{{ __('auth.activate_this_user') }}">
                              <span class="label label-danger label-sm">{{ __('auth.index_inactive_link') }}</span></a>
                          @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:user_delete('{{ $user->id }}')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
  </section>
  <!-- /.content -->
@stop

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">User delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('users.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="user_id" id="user_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-danger">Yes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('js')
<script>
  function user_delete (id)
  {
      var user_id = document.getElementById('user_id');
      user_id.value = id;
  }
</script>
@stop
