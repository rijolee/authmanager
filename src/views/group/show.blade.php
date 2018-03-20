@extends('authmanager::layout')

@section('menu_detl')
<!-- The Modal -->
<div id="popupPost" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">List User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
         <table class="table table-bordered" id="tb_users">
  
          <thead>
            <tr>
              <th>ID</th>
              <th>User Name</th>
              <th>User Email</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            @foreach($users as $g)
            <tr class="clickable-row">
                       <td>{{$g->user_id}}</td>
                       <td>{{$g->name}}</td>
                       <td>{{$g->email}}</td>
                       <td><a href="javascript:addUserGroup({{$g->user_id}});" class="btn btn-xs btn-info">
            Add
          </a></td>
                       
             </tr>
                
            @endforeach    
          </tbody>
          
          
        </table>

      </div>
      
    </div>

  </div>
</div>

<!-- End The Modal -->



<div class="col-lg-12">
<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none">
          Group Roles Information
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
          
          <table class="table table-bordered" id="tb_groups">
  
          <thead>
            <tr>
              <th>ID</th>
              <th>Group Role Name</th>
              <th>Description</th>
            <th class="tabledit-toolbar-column"><button id="button_add_row" ><span class="glyphicon glyphicon-plus"></span></button></th>
            </tr>
          </thead>
          <tbody>

            @foreach($groups as $g)
            <tr class="clickable-row">
                       <td>{{$g->grouproles_id}}</td>
                       <td>{{$g->grouproles_nm}}</td>
                       <td>{{$g->grouproles_desc}}</td>
                       
                       
             </tr>
                
            @endforeach    
          </tbody>
          <tfoot>
            <div class="text-center">
                {{$groups->links()}}
            </div>
          </tfoot>
          
        </table>

        </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link " data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="text-decoration: none">
         User Member Group
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        <button id="button_add_user" class="btn-info" >Add Member User</button>
                <button id="button_del_user" class="btn-danger" >Delete Member User</button>
                
      <table class="table table-bordered" id="tb_usergroups">
  
             
              
              
        </table>  
      </div>
    </div>
  </div>
  
</div>

</div>






@endsection

@section('scripts')
<script>

  function addUserGroup(id){
                    var grp_id = jQuery($("#tb_groups tr.active td:nth-child(1)").html()).text()  ;


                   var param = { grouproles_id : grp_id
                                                ,user_id : id
                                                };
                               
                        
                  //ajax
                    $.ajax({
                      type: "POST",
                      url:  "/authmanager/addusergroups/",
                      data : param,
                      dataType : 'json', 
                      success: function( response ) {

                        
                        if(typeof(response.success) != 'undefined' ){
                        toastr.info(response.success, '', {timeOut: 3000});
                        }
                        
                        if(typeof(response.error) != 'undefined' ){
                        toastr.warning(response.error, '', {timeOut: 3000});
                        }

                        loadUserGroup(grp_id);


                      }
                  });

                  //end
                }


          function loadUserGroup(id){

                    // $('#tb_usergroups tbody > tr').remove();

                    $('#tb_usergroups').bootstrapTable('destroy');
                    

                    $('#tb_usergroups').bootstrapTable({
                      pagination : true, //True to show a pagination toolbar on table bottom
                      url:  "/authmanager/usergroups/"+ id,
                      columns :[
                      {
                            title:'ch',
                            field:'select',
                            checkbox:true,
                            width:25,
                            align:'center',
                            valign:'middle'
                          },
                          {
                            title:'ID',
                            field:'grouproles_id',
                            visible:false
                          },
                          {
                            title:'ID',
                            field:'user_id',
                            visible:false
                          },
                          {
                            title:'User Name',
                            field:'name',
                            sortable:true
                          },
                          {
                            title:'User Email',
                            field:'email',
                            sortable:true
                          }
                        ],
                      dataType:'json',
                      clickToSelect: true, 
                      //pageList : [ 3, 5, 20 ],
                      pageSize : 5,
                      pageNumber : 1,
                      search : true,
                    });

                        
          //loaddetl
                  //   $.ajax({
                  //     type: "GET",
                  //     url:  "/authmanager/usergroups/"+ id,
                  //     dataType : 'json', 
                  //     success: function( response ) {
                  //       var trHTML = '';
                  //       $('#tb_eventmenu tbody > tr').remove();
                  //       $.each(response, function (i, item) {
                  //           trHTML += '<tr><td>' + item.name  + '</td>'+
                  //           '<td>' + item.email + '</td>'+
                  //           '</tr>';
                            
                  //       });

                        
                  //       $('#tb_usergroups tbody').append(trHTML);


                        


                  //     }
                  // });

                  //end
                }

               

  

         $(document).ready(function() {


          $('#tb_users').bootstrapTable({
            pagination : true, //True to show a pagination toolbar on table bottom
            //pageList : [ 3, 5, 20 ],
            pageSize : 5,
            pageNumber : 1,
            search : true,
          });

          



                


             



          document.getElementById("group_menu").className = "active";
            
                  // var dataSelect = '{"view": "View Only", "admin": "admin"}';

                  $('#tb_groups').on('click', '.clickable-row', function(event) {
                    $(this).addClass('active').siblings().removeClass('active');
                    var grp_id = $("#tb_groups tr.active td:nth-child(1)").html();
                    loadUserGroup(jQuery(grp_id).text());

                  });

                  


                            $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                            //alert('as');

                            // $('#tb_groups').bdt();


                            function doinitTabledit(){

                                $('#tb_groups').Tabledit({
                                url: '{{route('authmanager.group.action')}}',
                                restoreButton: false,
                                editButton: true,
                                hideIdentifier: false,
                                eventType: 'click',
                                columns: {
                                    identifier: [0, 'grouproles_id'],
                                    editable: [
                                    // [1, 'grouproles_nm','select',dataSelect]
                                    [1, 'grouproles_nm','input']
                                    ,[2, 'grouproles_desc','input']
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

                                var cnt = ($('#tb_groups tbody tr').length);

                                if(cnt==0){


                                var trHTML = '<tr><td>' + '' +'.'+''+ '</td>'+
                                  '<td>' + '' + '</td>'+
                                  '<td>' + '' + '</td>'+
                                  '</tr>';

                                $('#tb_groups tbody').append(trHTML);
                                doinitTabledit();  

                                //start
                                var tableditTableName = '#tb_groups';  // Identifier of table
                                var newID ='';
                                var clone = $("#tb_groups tbody tr:first").clone(); 
                                $('#tb_groups tbody > tr').remove();
                        
                                $(".tabledit-span", clone).text(""); 
                                $(".tabledit-input", clone).val(""); 
                                clone.prependTo("table"); 
                                $(tableditTableName + " tbody tr:first").attr("grouproles_id", newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                                $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 

                                }
                                else{
                                  var tableditTableName = '#tb_groups';  // Identifier of table
                                  //var newID = parseInt($(tableditTableName + " tr:last").attr("id")) + 1; 
                                  var newID ='';
                                  var clone = $("#tb_groups tbody tr:first").clone(); 
                                  $(".tabledit-span", clone).text(""); 
                                  $(".tabledit-input", clone).val(""); 
                                  clone.prependTo("table"); 
                                  $(tableditTableName + " tbody tr:first").attr("grouproles_id", newID); 
                                  $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                                  $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                                  $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 
                                }


                              
                                
                            });

                            $("#button_add_user").click(function() { 

                               var grp_id = jQuery($("#tb_groups tr.active td:nth-child(1)").html()).text()  ;

                            
                            if(grp_id =='')
                              toastr.warning('Select Group first', '', {timeOut: 3000});
                            else
                              $('#popupPost').modal('show');
                           });


                            $("#button_del_user").click(function() { 

                              var dataArr  = $('#tb_usergroups').bootstrapTable('getSelections');
                              var grp_id = jQuery($("#tb_groups tr.active td:nth-child(1)").html()).text()  ;

                              // alert(dataArr[0].grouproles_id);
                              var arrayLength = dataArr.length;
                              for (var i = 0; i < arrayLength; i++) {
                                  // var param = 'grouproles_id='+dataArr[i].grouproles_id+'&user_id='+dataArr[i].user_id;
                                  var param = { grouproles_id : dataArr[i].grouproles_id
                                                ,user_id : dataArr[i].user_id
                                                };

                                  //ajax
                                  $.ajax({
                                    type: "POST",
                                    url:  "/authmanager/delusergroups/",
                                    data : param,
                                    dataType : 'json', 
                                    success: function( response ) {
                                      
                                      if(typeof(response.success) != 'undefined' ){
                                      toastr.info(response.success, '', {timeOut: 3000});
                                      }
                                      
                                      if(typeof(response.error) != 'undefined' ){
                                      toastr.warning(response.error, '', {timeOut: 3000});
                                      }

                                      loadUserGroup(grp_id);


                                    }
                                });

                                //end
                              }

                              



                           });


            });

 


    </script>
@endsection

