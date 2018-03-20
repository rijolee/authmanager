@extends('authmanager::layout')

@section('menu_detl')

<div class="col-lg-3">
@include('authmanager::menu.sidebar')                   
</div>
                
<div class="col-lg-8">



<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none">
          Menu Detail Information
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
          <form action="{{route('authmanager.menu.update',['id'=>$menu_detl->menu_id])}}" method="post">
            {{csrf_field()}}

            <div class="form-group">
                  <label for="menu_id">Menu ID</label>
                  <input type="text" name = "menu_id" class="form-control" value="{{$menu_detl->menu_id}}" readonly>
            </div>
            <div class="form-group">
                  <label for="parent_id">Parent ID</label>
                  <input type="text" name = "parent_id" class="form-control" value="{{$menu_detl->parent_id}}" readonly>
            </div>
            <div class="form-group">
                  <label for="menu_nm">Menu Name</label>
                  <input type="text" name = "menu_nm" class="form-control" value="{{$menu_detl->menu_nm}}">
            </div>
            <div class="form-group">
                  <label for="menu_order">Menu Order</label>
                  <input type="text" name = "menu_order" class="form-control" value="{{$menu_detl->menu_order}}">
            </div>
            <div class="form-group">
                  <label for="system_nm">System Name</label>
                  <input type="text" name = "system_nm" class="form-control" value="{{$menu_detl->system_nm}}">
            </div>
            <div class="form-group">
                  <label for="url">Url</label>
                  <input type="text" name = "url" class="form-control" value="{{$menu_detl->url}}">
            </div>
            <div class="form-group">
                  <label for="url">Class</label>
                  <input type="text" name = "class" id = "class" class="form-control" value="{{$menu_detl->class}}">
            </div>

            <div class="form-group">
                  <label for="url">Desc</label>
                  <input type="text" name = "desc" id = "desc" class="form-control" value="{{$menu_detl->desc}}">
            </div>
            <div class="form-group">
                  <label for="disp_yn">Display this menu?</label>
                  <select name="disp_yn" id="disp_yn" class="form-control">
                  
                    <option value="0"
                      @if ('0' == $menu_detl->disp_yn)
                            selected="selected"
                      @endif
                      >
                      Yes
                    </option>

                    <option value="1"
                      @if ('1' == $menu_detl->disp_yn)
                            selected="selected"
                      @endif
                      >
                      No
                    </option>
                  

                  </select>
             </div>

            <div class="form-group">
                  <label for="created_at">Created At</label>
                  <input type="text" name = "created_at" class="form-control" value="{{$menu_detl->created_at}}" readonly>
            </div>

            <div class="form-group">
                  <label for="updated_at">Updated At</label>
                  <input type="text" name = "updated_at" class="form-control" value="{{$menu_detl->updated_at}}" readonly>
            </div>
            






            <div class="form-group">
                  <button class="btn btn-success" type="submit">Save</button>
            </div>



          </form>

        </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="text-decoration: none">
         Event / Roles
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
      <table class="table table-bordered" id="tb_eventmenu">
  
              <thead>
                <tr>
                  <th>row ID</th>
                  <th>Menu</th>
                  <th>Event/Role Name</th>
                <th class="tabledit-toolbar-column"><button id="button_add_row" ><span class="glyphicon glyphicon-plus"></span></button></th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
              
              
        </table>  
      </div>
    </div>
  </div>
  
</div>
</div>

@endsection

@section('scripts')
<script>

  function getAllChildren(treeObj, nodeId, result) {
          var node = treeObj.get_node(nodeId);
          result.push(node.id);
          if (node.children) {
            for (var i = 0; i < node.children.length; i++) {
              getAllChildren(treeObj, node.children[i], result);
            }
          }
        }

        
 $('#system').val('{!! $menu_detl->system_nm !!}');
 var menuId = '{!! $menu_detl->menu_id !!}';
var systemNm = '{!! $menu_detl->system_nm !!}';




        var dataEvent = {!!$events!!};
        //var dataSelect = JSON.stringify(dataEvent);
        // var dataSelect = '{"E1": "admin", "E2": "view"}';

        var arrdataSelect = '{';

        $.each(dataEvent, function (i, item) {

                          var id = item.event_id;
                          var nm = item.event_nm;
                          
                            
                          arrdataSelect += '"'+id+'":"'+nm+'"';
                          if(i != dataEvent.length-1 ) arrdataSelect += ',';
                          
                            
                        });

        arrdataSelect += '}';



        
            //alert(arrdataSelect[0]["firstName"]);


        $(document).ready(function() {

          

          function doinitTabledit(){


            var menu_id = $("#menu_id").val();
            var url = '/authmanager/eventmenusaction/';
            //alert(dataSelect);
            $('#tb_eventmenu').Tabledit({
                                url: url,
                                restoreButton: false,
                                editButton: true,
                                hideIdentifier: true,
                                eventType: 'click',
                                columns: {
                                    identifier: [0, 'row_id'],
                                    editable: [
                                      [2, 'event_id','select',arrdataSelect]
                                    ]
                                },
                                onSuccess(data,textStatus,jqXHR){
                                    console.log(data);
                                    //if(data == 'delete' || data == 'edit' )
                                    top.document.location.href="/authmanager/showmenu/"+ menuId+'/'+systemNm;
                  


                                }
                            });
          }

          


            document.getElementById("menu").className = "active";


              
               //alert(JSON.stringify(dataEvent));

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                            //alert('as');

                            // $('#example-2').bdt();



                            //loaddetl
                    $.ajax({
                      type: "GET",
                      url:  "/authmanager/eventmenus/"+ menuId,
                      dataType : 'json', 
                      success: function( response ) {
                        var trHTML = '';
                        $('#tb_eventmenu tbody > tr').remove();
                        $.each(response, function (i, item) {
                            trHTML += '<tr><td>' + item.menu_id +'.'+item.event_id + '</td>'+
                            '<td>' + item.menu_nm + '</td>'+
                            '<td>' + item.event_nm + '</td>'+
                            '</tr>';
                            
                        });

                        
                        $('#tb_eventmenu tbody').append(trHTML);
                        doinitTabledit();


                        


                      }
                  });

                  //end

                            




                            doinitTabledit();


                //                              $('#tb_eventmenu tbody > tr').remove();
                // //$('#tb_eventmenu tbody').append('<tr><td>asda</td><td>qew</td></tr>');


                            

                            $("#button_add_row").click(function() { 
                              var cnt = ($('#tb_eventmenu tbody tr').length);

                              if(cnt==0){
                                var trHTML = '<tr><td>' + '' +'.'+''+ '</td>'+
                                  '<td>' + '' + '</td>'+
                                  '<td>' + '' + '</td>'+
                                  '</tr>';

                                $('#tb_eventmenu tbody').append(trHTML);
                                //doinitTabledit();  

                                //start
                                var tableditTableName = '#tb_eventmenu';  // Identifier of table
                                var newID = menuId+'.new';
                                var clone = $("table tbody tr:first").clone(); 
                                $('#tb_eventmenu tbody > tr').remove();
                        
                                $(".tabledit-span", clone).text(""); 
                                $(".tabledit-input", clone).val(""); 
                                clone.prependTo("table"); 
                                $(tableditTableName + " tbody tr:first").attr("row_id", newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                                $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 


                              }else{
                                //var newID = parseInt($(tableditTableName + " tr:last").attr("id")) + 1; 
                                //var newID =$("#menu_id").val();
                                var tableditTableName = '#tb_eventmenu';  // Identifier of table
                                var newID =menuId+'.new';
                                var clone = $("table tbody tr:first").clone(); 
                                $(".tabledit-span", clone).text(""); 
                                $(".tabledit-input", clone).val(""); 
                                clone.prependTo("table"); 
                                $(tableditTableName + " tbody tr:first").attr("row_id", newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                                $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                                $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 
                              }



                                
                            });

                            // $('#button_add_row').click(function() {
                            //   var table = $('#tb_eventmenu');
                            //   var body = $('#tb_eventmenu tbody');
                            //   var nextId = body.find('tr').length + 1;
                            //   table.prepend($('' + nextId + ''));
                            //   table.Tabledit('update');
                            // });
            


               $('#jstree_menu').jstree({ 'core' : {
                    'data' : {!! $menus !!}
                } });

               $('#jstree_menu').on('loaded.jstree', function() {
                    $(this).jstree('open_all');
                  });

               $('#jstree_menu').on("changed.jstree", function (e, data) {




                  //toastr.info(data.selected, '', {timeOut: 3000});
                  //top.document.location.href="/authmanager/menu/"+ data.selected;

                  if ($('#menu_id').val() == '' && $('#parent_id').val() != ''){
                    top.document.location.href="/authmanager/showmenu/"+ data.selected+'/'+systemNm;
                  }
                  else{
                  $.ajax({
                      type: "GET",
                      url:  "/authmanager/menu/"+ data.selected,
                      dataType : 'json', 
                      success: function( msg ) {
                          //$('#menu_nm').val(msg.menu_nm);
                          for (var key in msg) {   
                    $('[name="'+key+'"]').val(msg[key]);
                  }
                  $('#system').val(msg.system_nm);

                  //loaddetl
                    $.ajax({
                      type: "GET",
                      url:  "/authmanager/eventmenus/"+ data.selected,
                      dataType : 'json', 
                      success: function( response ) {
                        var trHTML = '';
                        $('#tb_eventmenu tbody > tr').remove();
                        $.each(response, function (i, item) {
                            trHTML += '<tr><td>' + item.menu_id +'.'+item.event_id + '</td>'+
                            '<td>' + item.menu_nm + '</td>'+
                            '<td>' + item.event_nm + '</td>'+
                            '</tr>';
                            
                        });

                        
                        $('#tb_eventmenu tbody').append(trHTML);
                        doinitTabledit();


                        


                      }
                  });

                  //end

                  


                      }
                  });


                  




                  }

                       

                });


               
               
               
               
        });


        function addBelow(){
          
          var selectedData = [];
       var selectedIndexes;
        selectedIndexes = $("#jstree_menu").jstree("get_selected", true);
        jQuery.each(selectedIndexes, function (index, value) {
                selectedData.push(selectedIndexes[index].id);
                //alert(selectedIndexes[index].id);
        });

        //alert(selectedData[0]);
        var system_nm = systemNm;
        if(selectedData.length > 0)
         top.document.location.href="/authmanager/menucreatebelow/"+ selectedData[0]+"/"+system_nm;
        else
          toastr.warning('Select menu first', 'Warning', {timeOut: 3000});
          // var sel = $('#jstree_menu').jstree().get_selected(true)[0].text;

          // alert(sel);


        }   

        function del(){
          
             var selectedData = [];
             var selectedIndexes;
              selectedIndexes = $("#jstree_menu").jstree("get_selected", true);
              jQuery.each(selectedIndexes, function (index, value) {
                      selectedData.push(selectedIndexes[index].id);
                      //alert(selectedIndexes[index].id);
              });

              //alert(selectedData[0]);
              var system_nm = $('#system').val();

              if(selectedData.length > 0){
               // top.document.location.href="/authmanager/menu/destroy/"+ selectedData[0];
                 //start loop select
                for (var i = 0; i < selectedData.length; i++) {
                  var childs = [];
                  //get all child
                  getAllChildren($("#jstree_menu").jstree(true), selectedData[i], childs);

                  //loop for delete until child
                  for (var j = 0; j < childs.length; j++) {
                    //ajax
                    var param = { menu_id : childs[j]
                            };

                    $.ajax({
                      type: "POST",
                      url:  "/authmanager/menu/destroy",
                      data : param,
                      dataType : 'json', 
                      success: function( response ) {
                        
                        if(typeof(response.success) != 'undefined' ){
                       
                        if(i == selectedData.length && j == childs.length){
                          toastr.info('Menu successfully removed', '', {timeOut: 3000});
                          top.document.location.href="/authmanager/load/"+ system_nm;

                        }

                        }
                        
                       


                      }
                    });

                  }

                    

                  




                  //end loop
                }
                //end


              }
              else{
               toastr.warning('Select menu first', 'Warning', {timeOut: 3000});
              }


              




              
                


        }   


        function goto(){
          
          var system_nm = systemNm;
          if(system_nm == '')
            toastr.warning('Select your system first, type all if you want to Search all your system modul', 'Warning', {timeOut: 3000});
          else  
         top.document.location.href="/authmanager/load/"+ system_nm;
       

        }   


        function handleEnter(inField, e) {
          var charCode;
          
          if(e && e.which){
              charCode = e.which;
          }else if(window.event){
              e = window.event;
              charCode = e.keyCode;
          }

          if(charCode == 13) {
              //alert("Enter was pressed on " + inField.id);
              goto();
          }

          
      }






    </script>
@endsection

