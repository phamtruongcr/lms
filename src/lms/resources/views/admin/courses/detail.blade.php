@extends('layouts.app')
@section('title', 'chapters managerment')

@section('content')

<!-- Main content -->
  <div class="row">
    <div class="col-12">
        @include('_alert')
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3>
            @lang('form/course.Course')
            <a href="{{route('course.create')}}" 
              class="btn btn-flat btn-success btn-sm float-right">
              <i class="fas fa-plus-square"></i>
              @lang('form/course.Create')
            </a>
          </h3>
        </div>
        @if ($course)
        <div class="card-body">
        <h2>{{ $course->translate()->name }}</h2>
        <h4>
            @if(isset($course->start_at) && isset($course->finish_at))
            Time: {{Carbon\Carbon::parse($course->start_at)->format('d/m/Y')}} - {{Carbon\Carbon::parse($course->finish_at)->format('d/m/Y')}}
            @endif
        </h4>
        <hr>
        {!! $course->translate()->description !!}
        <hr>
        @endif
        <h3>
          Chapter 
          <a href="" data-toggle="modal" 
              data-target="#createChapterModal" class="text-success float-right">
            <i class="fas fa-plus-circle"></i>
          </a>
        </h3>
        @if( count($chapters)!=0 )
        <div class="col-12">
        <div class="card">
          <div class="card-body table-responsive p-0" style="height: 400px;">
            <table id="example1" class="table table-bordered table-striped table-head-fixed">
              <thead>
              <tr>
                <th>#</th>
                <th>@lang('form/chapter.Name chapter')</th>
                <th>@lang('form/chapter.Start')</th>
                <th>@lang('form/chapter.Finish')</th>
                <th>@lang('form/chapter.Create at')</th>
                <th>@lang('form/chapter.Update at')</th>
                <th>@lang('form/chapter.Action')</th>
              </tr>
              </thead>
              <tbody>
          @endif
              @forelse($chapters as $chapter)
                <tr>
                    <td>{{ $loop->iteration + ($chapters->currentPage() -1) * $chapters->perPage() }}</td>
                    <td>
                    <a href="{{route('chapter.detail', ['id'=>$chapter->id])}}">
                    {{ $chapter->name }}
                    </a>
                    </td>
                    <td>{{ Carbon\Carbon::parse($chapter->start_at)->format('d-m-Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($chapter->finish_at)->format('d-m-Y') }}</td>
                    <td>{{ $chapter->created_at->format('d-m-Y') }}</td>
                    <td>{{ $chapter->updated_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('chapter.edit', ['id'=>$chapter->id]) }}" 
                            class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger" data-toggle="modal" 
                            data-target="#deleteModal" onclick="javascript:chapter_delete('{{ $chapter->id }}')">
                          <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8">No Chapter</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
          <div class="card-footer clearfix">
            {{ $chapters->links() }}
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="card-footer clearfix">
          <a href="{{route('course.index')}}" 
              class="btn btn-flat btn-default btn-sm">
              <i class="fa fa-reply"></i> Cancel
          </a>
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
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" 
      data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">chapter delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('chapter.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="chapter_id" id="chapter_id" value="0">
        <input type="hidden" name="redirect" id="chapter_id" value="course">
      <div class="modal-body">
        Are you sure you want to delete this chapter?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-danger">Yes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="createChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createChapterModal">Create chapter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('chapter.store_chapter_of_course', ['course_id'=>$course->id]) }}" method="post">
          <div class="card-body row">
          <!-- /.card-header -->
          @include('admin/courses/_chapter_form')

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
<script>
  function chapter_delete (id)
  {
      var chapter_id = document.getElementById('chapter_id');
      chapter_id.value = id;
  }
</script>

<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, 
      "paging": false, "info": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
@stop