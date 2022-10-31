@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="col-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between aligin-items-center flex-wrap grid-margin">
        <div>
          <h4 class="mb-3 mb-md-0"> All Students</h4>
        </div>

        <div class="d-flex aligin-items-center flex-wrap text-nowrap">
          <a href="{{route('student.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0">
            Add New Student</a>
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
              <th>Student Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Last Login</th>
              <th>Create-at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($students as $student )
            <tr>
              <td>{{ $loop->iteration + ($students->currentPage() -1) * $students->perPage() }}</td>
              <td><a href="{{ route('student.show', $student->id) }}">
                  {{ $student->first_name. $student->last_name }}
                </a>
              </td>
              <td class="text-end">{{$student -> email}}</td>
              <td class="text-end">{{$student -> phone}}</td>
              <td class="text-end">{{$student -> address}}</td>
              <td class="text-end">{{$student -> last_login}}</td>
              <td class="text-end">{{$student -> created_at}}</td>
              <td style="white-space: nowrap;">
                <a href="{{ route('student.edit', [$student->id]) }}" class="btn btn-sm btn-warning">
                  Edit
                </a>
                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:student_delete('{{ $student->id }}')">
                  Delete</i></a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6">No Product.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    {{ $students->links() }}
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