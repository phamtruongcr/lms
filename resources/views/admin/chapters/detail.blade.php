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
            @lang('form/chapter.Chapter')
            <a href="{{route('chapter.create')}}" 
                class="btn btn-flat btn-success btn-sm float-right">@lang('form/chapter.Create')
            </a>
          </h3>
        </div>
        @if ($chapter)
        <div class="card-body">
        <h2>{{ $chapter->translate()->name }}</h2>
        <h4>
            Time: {{Carbon\Carbon::parse($chapter->start_at)->format('d/m/Y')}} - {{Carbon\Carbon::parse($chapter->finish_at)->format('d/m/Y')}}
        </h4>
        <hr>
        {!! $chapter->translate()->description !!} 
        <hr>
        <h3>
          Lessons 
          <a href="" data-toggle="modal" 
              data-target="#createChapterModal" class="text-success float-right">
            <i class="fas fa-plus-circle"></i>
          </a>
        </h3>
        @php
        $chapter_ids = []
        @endphp
        @if ($chapter->has('lessons'))
        @php
        $chapter_lessons = $chapter->lessons()->get()
        @endphp
        @if( count($chapter_lessons)!=0 )
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive p-0" style="height: 400px;">
              <table id="example1" class="table table-bordered table-striped table-head-fixed">
              <thead>
              <tr>
                <th>@lang('form/lesson.Name lesson')</th>
                <th>@lang('form/lesson.Create at')</th>
                <th>@lang('form/lesson.Update at')</th>
                <th>@lang('form/lesson.Action')</th>
              </tr>
              </thead>
              <tbody>
          @foreach($chapter_lessons as $lesson)
            @php
            $chapter_ids[] = $lesson->id
            @endphp
            <tr>
                <td>
                <a href="{{route('lesson.detail', ['slug'=>$lesson->slug])}}">
                {{ $lesson->translate()->name }}
                </a>
                </td>
                <td>{{ $lesson->created_at->format('d-m-Y') }}</td>
                <td>{{ $lesson->updated_at->format('d-m-Y') }}</td>
                <td>
                  <h4>
                    <a class="text-danger" data-toggle="modal" 
                        data-target="#deleteModal" onclick="javascript:lesson_delete('{{ $lesson->id }}', '{{ $chapter->id }}')">
                      <i class="fas fa-minus-circle"></i>
                    </a>
                  </h4>  
                </td>
            </tr>
          @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </div>
          @endif
          @endif
                
        @endif
        <!-- /.box-body -->
        <div class="card-footer clearfix">
        <a href="{{ route('chapter.edit', ['id'=>$chapter->id]) }}" class="btn btn-sm btn-success">
            <i class="fas fa-edit"></i> Edit
        </a>
        <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
        <a href="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" 
            class="btn btn-flat btn-default btn-sm">
          <i class="fa fa-reply"></i> 
          Cancel
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
        <h5 class="modal-title" id="deleteModalLabel">Lesson delete!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('lesson.destroy_chapter_lesson') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="lesson_id" id="lesson_id" value="0">
        <input type="hidden" name="chapter_id" id="chapter_id" value="0">
        <input type="hidden" name="redirect" id="chapter_id" value="detail">
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

<div class="modal fade" id="createChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createChapterModal">Add lesson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('lesson.add_lesson', ['chapter_id'=>$chapter->id]) }}" method="post">
          <div class="card-body row">
          <!-- /.card-header -->
          @csrf

          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label" for="lesson_ids">Select the Lesson</label>
              <select class="form-control selectpicker form-select @error('lesson_ids') is-invalid @enderror" 
                name="lesson_ids[]" multiple> 
                @forelse($lessons as $id=>$name) 
                  @if( !in_array($id, $chapter_ids) )
                  <option value="{{$id}}" >{{$name}}</option>
                  @endif
                @empty
                @endforelse
              </select>
              @error('lesson_ids')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
<script>
  function lesson_delete (id, chapter_id)
  {
      var lesson_id = document.getElementById('lesson_id');
      var id_chapter = document.getElementById('chapter_id');
      lesson_id.value = id;
      id_chapter.value = chapter_id;
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
      "paging": true, "info": false,
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