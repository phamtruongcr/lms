@extends('layouts.app')
@section('title', 'Courses managerment')

@section('content')

        <!-- Main content -->
    <div class="row">
        <div class="col-12">
            @include('_alert')
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="box-title">@lang('form/course.Course')</h3>
              <a href="{{route('course.create')}}" class="btn btn-flat btn-success btn-sm">@lang('form/course.Create')</a>
            </div>
            <div class="card-body table-responsive p-0" style="height: 400px;">
                
                    <table class="table table-bordered table-hover table-head-fixed">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('form/course.Name')</th>
                            <th>@lang('form/course.Image')</th>
                            <th>@lang('form/course.Start')</th>
                            <th>@lang('form/course.Finish')</th>
                            <th>@lang('form/course.Create at')</th>
                            <th>@lang('form/course.Update at')</th>
                            <th>@lang('form/course.Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td>{{ $loop->iteration + ($courses->currentPage() -1) * $courses->perPage() }}</td>
                            <td>
                            <a href="{{route('course.detail', ['id'=>$course->id])}}">
                            {{ $course->name }}
                            </a>
                            </td>
                            <td><img src="{{ asset(($course->image)?$course->image:'files/thumb.jpg') }}" class="img-thumbnail" alt="" style="width: 150px; height: 100px;"></td>
                            <td>{{ Carbon\Carbon::parse($course->start_at)->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($course->finish_at)->format('d-m-Y') }}</td>
                            <td>{{ $course->created_at->format('d-m-Y') }}</td>
                            <td>{{ $course->updated_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('course.edit', ['id'=>$course->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:course_delete('{{ $course->id }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="8">No Courses</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="card-footer clearfix">
              {{ $courses->links() }}
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
        <h5 class="modal-title" id="deleteModalLabel">Course delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('course.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="course_id" id="course_id" value="0">
      <div class="modal-body">
        Are you sure you want to delete this course?
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
  function course_delete (id)
  {
      var course_id = document.getElementById('course_id');
      course_id.value = id;
  }
  // ajax search
  $(document).ready(function(){
    $('#search-input').on('keyup',function(){
      var content_search=$('#search-input').val();
      $.ajax({
        url:"{{ url('admin/courses/search') }}",
        type:'get',
        data: {
          content_search: content_search,
          _token: "{{ csrf_token() }}",
        },
        dataType:"json",
        success:function(result){
          html='';
            $.each(result.courses,function(key,course){
              html+= '<tr>'
                      +'<td scope="row">'+'</td>'
                      +'<td>'+ course.name+'</td>'
                      +'<td> <img src="" class="img-thumbnail" alt="" style="width: 150px; height: 100px;"></td>'
                      +'<td class="text-end">'+ course.start_at +'</td>'
                      +' <td class="text-end">'+ course.finish_at +'</td>'
                      +'<td class="text-end">'+ course.created_at +'</td>'
                      +'<td class="text-end">'+ course.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ course.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ course.id +')"><i class="fas fa-trash-alt"></i></a>'
                      +'</td>'
                  +'</tr>'
            });
            $('#table_questions').html(html);

        }
      })
    });
  });

</script>
@stop