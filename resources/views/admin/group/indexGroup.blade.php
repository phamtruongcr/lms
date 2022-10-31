@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="col-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between aligin-items-center flex-wrap grid-margin">
        <div>
          <h4 class="mb-3 mb-md-0"> All Course with class </h4>
        </div>

        <div class="d-flex aligin-items-center flex-wrap text-nowrap">
          <a href="{{route('group.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0">
            Add Course for class</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Class Name</th>
              <th>Class Manager</th>
              <th>Class Created-at</th>
              <th>Class Updated-at</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody>
            @forelse ($datas as $data )
            <tr>
              <td>{{ $loop->iteration + ($datas->currentPage() -1) * $datas->perPage() }}</td>
              <td><a href="#">
                  {{ $data->name }}
                </a>
              </td>
              <td>{{ $data->manager_name }}</td>
              <td class="text-end">{{$data -> created_at}}</td>
              <td class="text-end">{{$data -> updated_at}}</td>
              <td>
                  <a href="" class="btn btn-sm btn-success">
                  <i class="fas fa-edit"></i>
                  </a>
                  <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" 
                    onclick="javascript:test_delete('{{ $data->id }}')"><i class="fas fa-trash-alt"></i></a>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="6">No Class.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@stop

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Student delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('student.delete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="student_id" id="student_id" value="0">
        <div class="modal-body">
          Are you sure you want to delete this student?
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
  function student_delete(id) {
    var student_id = document.getElementById('student_id');
    student_id.value = id;
  }
</script>
@stop