@extends('layouts.app')
@section('title', __('form/question.Questions management'))

@section('content')
        <!-- Main content -->
        <div class="row">
        <div class="col-12">
            @include('admin/_alert')
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="box-title">@lang('form/question.Question Managements')</h3>
              <a href="{{route('question.create')}}" class="btn btn-flat btn-success btn-sm">@lang('form/question.Create a question')</a>
            </div>
            <div class="card-body">
                
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th scope='col'>@lang('form/question.Content')</th>
                            <th scope='col'>@lang('form/question.Lesson name')</th>
                            <th scope='col'>@lang('form/question.Status')</th>
                            <th scope='col'>@lang('form/question.Type')</th>
                            <th scope='col'>@lang('form/question.Point')</th>
                            <th scope='col'>@lang('form/question.Created at')</th>
                            <th scope='col'>@lang('form/question.Updated at')</th>
                            <th scope='col'>@lang('form/question.Action')</th>
                        </tr>
                        </thead>
                        <tbody id="table_questions">
                        @forelse($questions as $question)
                        <tr>
                            <td scope="row">{{ $loop->iteration + ($questions->currentPage() -1) * $questions->perPage() }}</td>
                            <td>
                            {{ $question->content }}
                            </td>
                            <td>{{ $question->lesson_name }}</td>
                            <td class="text-end">{{ $question->status_name }}</td>
                            <td class="text-end">{{ $question->type_name }}</td>
                            <td class="text-end">{{ $question->point }}</td>
                            <td class="text-end">{{ $question->created_at->format('d-m-Y') }}</td>
                            <td class="text-end">{{ $question->updated_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('question.edit', ['id'=>$question->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" 
                                  onclick="javascript:question_delete('{{ $question->id }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7">No Questions</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="card-footer clearfix">
              {{ $questions->links() }}
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
        <h5 class="modal-title" id="deleteModalLabel">{{ __('form/question.Question delete!') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('question.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="question_id" id="question_id" value="0">
      <div class="modal-body">
        {{ __('form/question/Are you sure want to delete this question?') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('form/question.No') }}</button>
        <button type="submit" class="btn btn-danger">{{ __('form/question.Yes') }}</button>
      </div>
      </form>
    </div>
  </div>
</div>
@stop
@section('filter')
<fieldset>
    <legend>Choose types:</legend>
    @forelse($types as $type)
    <div>
      <lable>
        <input type="checkbox" name="type" value="{{ $type->value }}">{{ $type->name }}
      </lable>
    </div>
    @empty
    @endforelse
</fieldset>
</br>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
  
  function question_delete (id)
  {
      var question_id = document.getElementById('question_id');
      question_id.value = id;
  }
  // ajax search
  $(document).ready(function(){
    $('#search-input').on('keyup',function(){
      var content_search=$('#search-input').val();
      $.ajax({
        url:"{{ url('admin/questions/search') }}",
        type:'get',
        data: {
          content_search: content_search,
          _token: "{{ csrf_token() }}",
        },
        dataType:"json",
        success:function(result){
          html='';
            $.each(result.questions,function(key,question){
              html+= '<tr>'
                      +'<td scope="row">'+'</td>'
                      +'<td>'+ question.content+ '</td>'
                      +'<td>'+ question.lesson_name +'</td>'
                      +'<td class="text-end">'+ question.status_name +'</td>'
                      +'<td class="text-end">'+ question.type_name +'</td>'
                     +' <td class="text-end">'+ question.point +'</td>'
                      +'<td class="text-end">'+ question.created_at +'</td>'
                      +'<td class="text-end">'+ question.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ question.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ question.id +')"><i class="fas fa-trash-alt"></i></a>'
                      +'</td>'
                  +'</tr>'
            });
            $('#table_questions').html(html);

        }
      })
    });
  });

$(document).ready(function() {
    $("input[type='checkbox']").click(function() {
        var typePref = [];
        $.each($("input[name='type']:checked"), function() {
            typePref.push($(this).val());
        });
        var statusPref = [];
        $.each($("input[name='status']:checked"), function() {
            statusPref.push($(this).val());
        });
        $.ajax({
          url: "{{ url('admin/questions/filter') }}",
          type: 'get',
          data: {
            type: typePref,
            status: statusPref,
            _token: "{{ csrf_token() }}",
          },
          dataType: 'json',
          success: function(data) {
            console.log(data);
            html='';
            $.each(data.questions,function(key,question){
              html+= '<tr>'
                      +'<td>#</td>'
                      +'<td>'+ question.content+ '</td>'
                      +'<td>'+ question.lesson_name +'</td>'
                      +'<td class="text-end">'+ question.status_name +'</td>'
                      +'<td class="text-end">'+ question.type_name +'</td>'
                     +' <td class="text-end">'+ question.point +'</td>'
                      +'<td class="text-end">'+ question.created_at+'</td>'
                      +'<td class="text-end">'+ question.updated_at +'</td>'
                      +'<td>'
                          +'<a href="questions/edit/'+ question.id +'" class="btn btn-sm btn-success">'
                         +' <i class="fas fa-edit"></i>'
                          +'</a>'
                          +'<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"'
                           + 'onclick="javascript:question_delete('+ question.id +')"><i class="fas fa-trash-alt"></i></a>'
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