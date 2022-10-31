@extends('layouts.app')

@section('content')
  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-12">
              @include('_alert')
          </div>

          <div class="col-12">
              <div class="card">
                  <div class="card-header with-border">
                      <h3 class="card-title">@lang('auth.index_roles')</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <a href="{{route('roles.create')}}"
                          class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
                      <hr>
                      <table class="table table-striped table-bordered table-hover table-condensed">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>@lang('auth.index_name_th')</th>
                              <th>@lang('auth.index_slug_th')</th>
                              <th>@lang('auth.index_created_at')</th>
                              <th>@lang('auth.index_updated_at')</th>
                              <th>@lang('auth.index_action_th')</th>
                          </tr>
                          </thead>
                          <tbody>
                            @forelse($roles as $role)
                              <tr>
                                <td>
                                  {{ $loop->iteration + ($roles->currentPage() -1) * $roles->perPage() }}
                                </td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>{{ $role->updated_at }}</td>
                                <td style="white-space: nowrap;">
                                  <a href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-sm btn-success">
                                  <i class="fas fa-edit"></i>
                                  </a>
                                  <a class="btn btn-sm btn-success" href="{{ route('roles.duplicate', $role->id) }}" title="Duplicate">
                                  <i class="fas fa-copy"></i>
                                  <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"
                                  onclick="javascript:role_delete('{{ $role->id }}')"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                            @empty
                            @endforelse
                          </tbody>
                      </table>
                      {{ $roles->links() }}
                  </div>
                  <!-- /.card-body -->
              </div>
              <!-- /.card -->
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
        <h5 class="modal-title" id="deleteModalLabel">Role delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('roles.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="role_id" id="role_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this role?
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
  function role_delete (id)
  {
      var role_id = document.getElementById('role_id');
      role_id.value = id;
  }
</script>
@stop