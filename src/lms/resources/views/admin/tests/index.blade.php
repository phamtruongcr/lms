@extends('layouts.app')
@section('title', __('form/test.Tests management'))

@section('content')
        <!-- Main content -->
        <div class="row">
        <div class="col-12">
            @include('admin/_alert')
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="box-title">@lang('form/test.Test Managements')</h3>
              <a href="{{route('test.create')}}" class="btn btn-flat btn-success btn-sm">@lang('form/test.Create a test')</a>
            </div>
            <div class="card-body">
                
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th scope='col'>@lang('form/test.Name')</th>
                            <th scope='col'>@lang('form/test.Lesson name')</th>
                            <th scope='col'>@lang('form/test.Status')</th>
                            <th scope='col'>@lang('form/test.Total time')</th>
                            <th scope='col'>@lang('form/test.Total point')</th>
                            <th scope='col'>@lang('form/test.Limit')</th>
                            <th scope='col'>@lang('form/test.Created at')</th>
                            <th scope='col'>@lang('form/test.Updated at')</th>
                            <th scope='col'>@lang('form/test.Action')</th>
                        </tr>
                        </thead>
                        <tbody id="table_tests">
                        @forelse($tests as $test)
                        <tr>
                            <td scope="row">{{ $loop->iteration + ($tests->currentPage() -1) * $tests->perPage() }}</td>
                            <td>
                            {{ $test->name }}
                            </td>
                            <td>{{ $test->lesson_name }}</td>
                            <td class="text-end">{{ $test->status_name }}</td>
                            <td class="text-end">{{ $test->total_time }}</td>
                            <td class="text-end">{{ $test->total_point }}</td>
                            <td class="text-end">{{ $test->limit }} </td>
                            <td class="text-end">{{ $test->created_at->format('d-m-Y') }}</td>
                            <td class="text-end">{{ $test->updated_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('test.edit', ['id'=>$test->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" 
                                  onclick="javascript:test_delete('{{ $test->id }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="10">No Tests</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="card-footer clearfix">
              {{ $tests->links() }}
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
        <h5 class="modal-title" id="deleteModalLabel">{{ __('form/test.Test delete!') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('test.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="test_id" id="test_id" value="0">
      <div class="modal-body">
        {{ __('form/test/Are you sure want to delete this test?') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('form/test.No') }}</button>
        <button type="submit" class="btn btn-danger">{{ __('form/test.Yes') }}</button>
      </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('filter')
<fieldset>
    <legend>Choose status:</legend>
    @forelse($status as $sta)
    <div>
      <lable>
        <input type="checkbox" name="status" value="{{ $sta->value }}">{{ $sta->name }}
      </lable>
    </div>
    @empty
    @endforelse
</fieldset>
@stop

@section('js')
<script>
  function test_delete (id)
  {
      var question_id = document.getElementById('test_id');
      question_id.value = id;
  }
  // ajax search
  $(document).ready(function(){
    $('#search-input').on('keyup',function(){
      var content_search=$('#search-input').val();
      $.ajax({
        url:"{{ url('admin/tests/search') }}",
        type:'get',
        data: {
          content_search: content_search,
          _token: "{{ csrf_token() }}",
        },
        dataType:"json",
        success:function(result){
          html='';
            $.each(result.tests,function(key,test){
              html+= '<tr>'+
                      +'<td scope="row">'+'</td>'
                      +'<td>'+ test.name+ '</td>'+
                      +'<td>'+ test.lesson_name +'</td>'
                      +'<td class="text-end">'+ test.status_name +'</td>'
                      +'<td class="text-end">'+ test.total_time +'</td>'
                     +' <td class="text-end">'+ test.total_point +'</td>'
                     +' <td class="text-end">'+ test.limit +'</td>'
                      +'<td class="text-end">'+ test.created_at +'</td>'
                      +'<td class="text-end">'+ test.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ test.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ test.id +')"><i class="fas fa-trash-alt"></i></a>'
                      +'</td>'
                  +'</tr>';
            });
            $('#table_tests').html(html);

        }
      })
    });
  });

$(document).ready(function() {
    $("input[type='checkbox']").click(function() {
        var statusPref = [];
        $.each($("input[name='status']:checked"), function() {
            statusPref.push($(this).val());
        });
        $.ajax({
          url: "{{ url('admin/tests/filter') }}",
          type: 'get',
          data: {
            status: statusPref,
            _token: "{{ csrf_token() }}",
          },
          dataType: 'json',
          success: function(data) {
            html='';
            $.each(data.tests,function(key,test){
              html+= '<tr>'
                      +'<td scope="row">'+'</td>'
                      +'<td>'+ test.name+ '</td>'
                      +'<td>'+ test.lesson_name +'</td>'
                      +'<td class="text-end">'+ test.status_name +'</td>'
                      +'<td class="text-end">'+ test.total_time +'</td>'
                     +' <td class="text-end">'+ test.total_point +'</td>'
                     +' <td class="text-end">'+ test.limit +'</td>'
                      +'<td class="text-end">'+ test.created_at +'</td>'
                      +'<td class="text-end">'+ test.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ test.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ test.id +')"><i class="fas fa-trash-alt"></i></a>'
                      +'</td>'
                  +'</tr>';
            });
            $('#table_tests').html(html);
          }
        })
    });
});

</script>
@stop