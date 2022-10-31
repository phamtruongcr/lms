html='<div class="p3 control-sidebar-content"></div>'
$('.control-sidebar-dark').html(html);
var container=$('.control-sidebar-content');
console.log(container);
$(document).ready(function() {
    $('#button_filter').on('click',function() {
        $.ajax({
            url: "questions/getStatus",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}"},
            dataType: 'json',
            success: function(result) {
                html='<h6>Type</h6>';
                $.each(result.types, function(key,type){
                    html+='<div class="mb-4">' 
                          +'<input type="checkbox" class="mr-1" value="'+type.value+'"'
                          +'<span>'+type.name+'</span>'
                    +'</div>'
                })
                container.append(html);
               
            }
        })
    })
})