@extends('authmanager::layout')

@section('menu_detl')


<table class="table table-bordered" id="tb_events">
  
  <thead>
    <tr>
      <th>ID</th>
      <th>Event/Role Name</th>
      <th>Description</th>
    <th class="tabledit-toolbar-column"><button id="button_add_row" ><span class="glyphicon glyphicon-plus"></span></button></th>
    </tr>
  </thead>
  <tbody>

    @foreach($events as $e)
    <tr class="clickable-row">
               <td>{{$e->event_id}}</td>
               <td>{{$e->event_nm}}</td>
               <td>{{$e->event_desc}}</td>
     </tr>
        
    @endforeach    
  </tbody>
  <tfoot>
    <div class="text-center">
        {{$events->links()}}
    </div>
  </tfoot>
  
</table>


@endsection

@section('scripts')
<script>

         $(document).ready(function() {

          document.getElementById("event_menu").className = "active";
            
                  // var dataSelect = '{"view": "View Only", "admin": "admin"}';

                  $('#tb_events').on('click', '.clickable-row', function(event) {
                    $(this).addClass('active').siblings().removeClass('active');
                    //var a = $("#tb_events tr.active td:nth-child(1)").html();
                  // alert(jQuery(a).text());

                  });


                            $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                            //alert('as');

                            // $('#tb_events').bdt();


                            function doinitTabledit(){

                                $('#tb_events').Tabledit({
                                url: '{{route('authmanager.events.action')}}',
                                restoreButton: false,
                                editButton: true,
                                hideIdentifier: false,
                                eventType: 'click',
                                columns: {
                                    identifier: [0, 'event_id'],
                                    editable: [
                                    // [1, 'event_nm','select',dataSelect]
                                    [1, 'event_nm','input']
                                    ,[2, 'event_desc','input']
                                    ]
                                },
                                onSuccess(data,textStatus,jqXHR){
                                    console.log(data);
                                    //if(data == 'delete' || data == 'edit' )
                                    location.reload();


                                }
                                });
                              
                            }


                            doinitTabledit();

                            



                            

                            

                            $("#button_add_row").click(function() { 

                                var cnt = ($('#tb_events tbody tr').length);

                                if(cnt==0){


                                var trHTML = '<tr><td>' + '' +'.'+''+ '</td>'+
                                  '<td>' + '' + '</td>'+
                                  '<td>' + '' + '</td>'+
                                  '</tr>';

                                $('#tb_events tbody').append(trHTML);
                                doinitTabledit();  

                                //start
                                var tableditTableName = '#tb_events';  // Identifier of table
                                var newID ='';
                                var clone = $("table tbody tr:first").clone(); 
                                $('#tb_events tbody > tr').remove();
                        
                                $(".tabledit-span", clone).text(""); 
                                $(".tabledit-input", clone).val(""); 
                                clone.prependTo("table"); 
                                $(tableditTableName + " tbody tr:first").attr("event_id", newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                                $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 

                                }
                                else{
                                  var tableditTableName = '#tb_events';  // Identifier of table
                                  //var newID = parseInt($(tableditTableName + " tr:last").attr("id")) + 1; 
                                  var newID ='';
                                  var clone = $("table tbody tr:first").clone(); 
                                  $(".tabledit-span", clone).text(""); 
                                  $(".tabledit-input", clone).val(""); 
                                  clone.prependTo("table"); 
                                  $(tableditTableName + " tbody tr:first").attr("event_id", newID); 
                                  $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                                  $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                                  $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 
                                }


                              
                                
                            });


            });

 


    </script>
@endsection

