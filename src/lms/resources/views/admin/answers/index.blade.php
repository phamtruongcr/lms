@extends('layouts.app')
@section('title', __('form/answer.Answers management'))

@section('content')
        <!-- Main content -->
        <div class="row">
        <div class="col-12">
            @include('admin/_alert')
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="box-title">@lang('form/answer.Answer Managements')</h3>
              <a href="{{route('answer.create')}}" class="btn btn-flat btn-success btn-sm">@lang('form/answer.Create answer')</a>
            </div>
            <div class="card-body">
                
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('form/answer.Content')</th>
                            <th>@lang('form/amswer.Lesson name')</th>
                            <th>@lang('form/answer.Status')</th>
                            <th>@lang('form/answer.Create at')</th>
                            <th>@lang('form/answer.Update at')</th>
                            <th>@lang('form/answer.Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($answers as $answer)
                        <tr>
                            <td>{{ $loop->iteration + ($answers->currentPage() -1) * $answers->perPage() }}</td>
                            <td>
                            {{ $answer->content }}
                            </td>
                            <td>{{ $answer->lesson_name }}</td>
                            <td>{{ $answer->status }}</td>
                            <td>{{ $answer->created_at->format('d-m-Y') }}</td>
                            <td>{{ $answer->updated_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('answer.edit', ['id'=>$answer->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" 
                                  onclick="javascript:answer_delete('{{ $answer->id }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7">No Answers</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="card-footer clearfix">
              {{ $answers->links() }}
            </div>
           
          </div>
              <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->

  <!-- /.content -->
@stop

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Answer delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('answer.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="answer_id" id="answer_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this answer?
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
  function answer_delete (id)
  {
      var product_id = document.getElementById('answer_id');
      product_id.value = id;
  }
</script>
@stop