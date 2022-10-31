@extends('layouts.app')
@section('title', 'Lessons managerment')

@section('content')

        <!-- Main content -->
    <div class="row">
        <div class="col-12">
            @include('_alert')
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="box-title">@lang('form/lesson.Lesson')</h3>
              <a href="{{route('lesson.create')}}" class="btn btn-flat btn-success btn-sm">@lang('form/lesson.Create')</a>
            </div>
            <div class="card-body">
                
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('form/lesson.Name')</th>
                            <th>@lang('form/lesson.Status name')</th>
                            <th>@lang('form/lesson.Create at')</th>
                            <th>@lang('form/lesson.Update at')</th>
                            <th>@lang('form/lesson.Action')</th>
                        </tr>
                        </thead>
                        <tbody id="table_lessons">
                        @forelse($lessons as $lesson)
                        <tr>
                            <td>{{ $loop->iteration + ($lessons->currentPage() -1) * $lessons->perPage() }}</td>
                            <td>
                            <a href="{{route('lesson.detail', ['slug'=>$lesson->slug])}}">
                            {{ $lesson->name }}
                            </a>
                            </td>
                            <td>{{ $lesson->status_name }}</td>
                            <td>{{ $lesson->created_at->format('d-m-Y') }}</td>
                            <td>{{ $lesson->updated_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('lesson.edit', ['id'=>$lesson->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:lesson_delete('{{ $lesson->id }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="6">No Lessons</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="card-footer clearfix">
              {{ $lessons->links() }}
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
        <h5 class="modal-title" id="deleteModalLabel">Lesson delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('lesson.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="lesson_id" id="lesson_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this lesson?
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
  function lesson_delete (id)
  {
      var lesson_id = document.getElementById('lesson_id');
      lesson_id.value = id;
  }
  // ajax search
  $(document).ready(function(){
    $('#search-input').on('keyup',function(){
      var content_search=$('#search-input').val();

      $.ajax({
        url:"{{ url('admin/lessons/search') }}",
        type:'get',
        data: {
          content_search: content_search,
          _token: "{{ csrf_token() }}",
        },
        dataType:"json",
        success:function(result){
          html='';
          if (result.length!=0 ){
            $.each(result.lessons,function(key,lesson){
              html+= '<tr>'
                      +'<td scope="row">'+'</td>'
                      +'<td>'+ lesson.name+'</td>'
                      +'<td>'+lesson.status_name+'</td>'
                      +'<td class="text-end">'+ lesson.created_at +'</td>'
                      +'<td class="text-end">'+ lesson.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ lesson.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ lesson.id +')"><i class="fas fa-trash-alt"></i></a>'
                      +'</td>'
                  +'</tr>'
            });
          }
          else {
            html+='<tr>'
                +'<td colspan="8">No lessons</td>'
              +'</tr>';
          }
            $('#table_lessons').html(html);

        }
      })
    });
  });
</script>
@stop