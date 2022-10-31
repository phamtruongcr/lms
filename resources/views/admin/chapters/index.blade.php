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
          <h3 class="card-title">@lang('form/chapter.Chapter')</h3>
          <div class="card-tools">
            <a href="{{route('chapter.create')}}" 
                class="btn btn-flat btn-success btn-sm">@lang('form/chapter.Create')
            </a>
          </div>
        </div>
        <div class="card-body table-responsive p-0" style="height: 400px;">
          <table class="table table-bordered table-hover table-head-fixed">
              <thead>
              <tr>
                  <th>#</th>
                  <th>@lang('form/chapter.Name chapter')</th>
                  <th>@lang('form/chapter.Name course')</th>
                  <th>@lang('form/chapter.Start')</th>
                  <th>@lang('form/chapter.Finish')</th>
                  <th>@lang('form/chapter.Create at')</th>
                  <th>@lang('form/chapter.Update at')</th>
                  <th>@lang('form/chapter.Action')</th>
              </tr>
              </thead>
              <tbody id="table_chapters">
              @forelse($chapters as $chapter)
              <tr>
                  <td>{{ $loop->iteration + ($chapters->currentPage() -1) * $chapters->perPage() }}</td>
                  <td>
                  <a href="{{route('chapter.detail', ['id'=>$chapter->id])}}">
                  {{ $chapter->name }}
                  </a>
                  </td>
                  <td>{{ $chapter->course_name }}</td>
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
                <td colspan="8">No chapters</td>
              </tr>
              @endforelse
              </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="card-footer clearfix">
          {{ $chapters->links() }}
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
@stop

@section('js')
<script>
  function chapter_delete (id)
  {
      var chapter_id = document.getElementById('chapter_id');
      chapter_id.value = id;
  }
  // ajax search
  $(document).ready(function(){
    $('#search-input').on('keyup',function(){
      var content_search=$('#search-input').val();

      $.ajax({
        url:"{{ url('admin/chapters/search') }}",
        type:'get',
        data: {
          content_search: content_search,
          _token: "{{ csrf_token() }}",
        },
        dataType:"json",
        success:function(result){
          html='';
          if (result.length!=0 ){
            $.each(result.chapters,function(key,chapter){
              html+= '<tr>'
                      +'<td scope="row">'+'</td>'
                      +'<td>'+ chapter.name+'</td>'
                      +'<td>'+chapter.course_name+'</td>'
                      +'<td class="text-end">'+ chapter.start_at +'</td>'
                      +' <td class="text-end">'+ chapter.finish_at +'</td>'
                      +'<td class="text-end">'+ chapter.created_at +'</td>'
                      +'<td class="text-end">'+ chapter.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ chapter.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ chapter.id +')"><i class="fas fa-trash-alt"></i></a>'
                      +'</td>'
                  +'</tr>'
            });
          }
          else {
            html+='<tr>'
                +'<td colspan="8">No chapters</td>'
              +'</tr>';
          }
            $('#table_chapters').html(html);

        }
      })
    });
  });

</script>
@stop