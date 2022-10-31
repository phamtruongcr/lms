@extends('layouts.app')
@section('title', ('form/test.Update'))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">{{ __('form/test.Tests management') }}</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group me-2">
    <a class="btn btn-sm btn-primary" href="{{ route('test.create') }}">{{ __('form/test.Create a test') }}</a>
  </div>
</div>
</div>
<h2>{{ __('form/test.Update test') }} {{ $test->id }}</h2>
<div>
  <form method="post" action="{{ route('test.update', [$test->id]) }}"
  enctype="multipart/form-data">
    @include('admin/tests/_test_form')
  <button type="submit" class="btn btn-primary">{{ __('form/test.Save') }}</button>
  </form>
</div>
@stop

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
            ClassicEditor
            .create( document.querySelector( '#other_description' ) )
            .catch( error => {
                console.error( error );
            } );
            var otherlang=document.getElementById('btn_other_language');
        var content_lang=document.getElementById('form_other_lang');
        otherlang.addEventListener('click', function(){
          content_lang.style.display='block';
          otherlang.style.display='none';
        });
  // load ajax

 var selectedItem=[];
 var form_questions=document.getElementById('preview_questions').children;
 var form_id='';
 for (var i=0;i<form_questions.length;i++){
  form_id+=form_questions[i].dataset.id;
  if(i<form_questions.length-1){
    form_id+=',';
  }
 }
 if (form_id==''){
  var list_id_selected=[];
 }
 else {
  var list_id_selected=form_id.split(',');
 }
    
    $(document).ready(function(){
      $('#test_category').on('change', function(){       
        var category_id=this.value;    
        $('#test_questions').html('');
        $.ajax({
          url:"{{ url('admin/tests/get-question-by-lesson')}}",
          type:"POST",
          data: {
              category_id: category_id,
              _token: "{{ csrf_token() }}"
              },
          dataType:"json",
          success: function(result){
            selectedItem=list_id_selected;
            html='';
            $.each(result.questions,function(key,value){
              html+='<option value="'+value.id+'" point="'+value.point+'">'+value.content+': '+value.point +'</option>';
            });
            $("#test_questions").html(html);
            $('#test_questions').attr('multiple','true');
             $('#test_questions').selectpicker();
             $('#test_questions').selectpicker('refresh');

          }
        
        });
      });
    });
    //ajax load total_point of test
      $('#test_questions').on('change', function(){
           list_id_selected=selectedItem.concat($('#test_questions').val());
         
  
        $.ajax({
          url:"{{ url('admin/tests/get-total-point')}}",
          type:"POST",
          data: {
              point: list_id_selected,
              _token: "{{ csrf_token() }}"
              },
          dataType:"json",
          success: function(result){
            html='';
            total_point=0;
            for(var i=0; i<result.list_question.length; i++){
              html+='<tr data-point="'+result.list_question[i][0].point+'" data-id="'+ result.list_question[i][0].id+ '">'
                   +'<td>'+ result.list_question[i][0].id+ '</td>'
                   +'<td>'+result.list_question[i][0].content+'</td>'
                   +'<td class="point text-end" >'+result.list_question[i][0].point+'</td>'
                   +'<td class="text-end">'+result.list_question[i][0].type+'</td>'
                   +'<td>'
                   +'<div class="delete_pre_question" onclick="deleteRow(this)">'
                   +'<i class="fas fa-minus-circle text-danger"></i>'
                   +'</div'
                    +'</td>'
 
              +'</tr>';
              
            }
            $('#preview_questions').html(html); 
           
            var list_id=document.getElementById('preview_questions').children;
            var id='';
            for (var i=0; i<list_id.length; i++){
              id+=list_id[i].dataset.id;
              total_point+=parseFloat(list_id[i].dataset.point);
              if(i<list_id.length-1){
                id+=',';
              }

        }
        $('#total_point').val(total_point);
       $('#list_question_id').val(id);
          }
        });
      });
    //delete preview question
    function deleteRow(row)
    {
        var i=row.parentNode.parentNode.rowIndex;
       
        var points=row.parentNode.parentNode.dataset.point;
        var current_point=$('#total_point').val();
        current_point=current_point-points;
        $('#total_point').val(current_point);
        document.getElementById('table_questions').deleteRow(i);
        var list_id=document.getElementById('preview_questions').children;
        var id='';
        console.log(list_id.length);
        if (list_id.length!=0){
          for (var i=0; i<list_id.length; i++){
          id+=list_id[i].dataset.id;
          if(i<list_id.length-1){
            id+=',';
          }
        }     
          list_id_selected=id.split(',');
        }
       if (list_id.length==0){
          //khi xóa hết tránh xâu rỗng
          list_question_id=[];
        }
       $('#list_question_id').val(id);
    }
    
    </script>
@stop