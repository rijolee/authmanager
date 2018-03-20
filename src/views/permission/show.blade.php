@extends('authmanager::layout')

@section('menu_detl')




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
         Menu Permission
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
          <div class="col-lg-6">
          
                              <input type="text" name="system" id="system" value="all" placeholder="Search system name.." width="100%" onkeypress="handleEnter(this, event)">
                <a href="javascript:loadTrees();" ><span class="glyphicon glyphicon-search"></span></a> 

               <a href="javascript:saveMenuPerm();"  class="form-control btn btn-info">Save</a>
                

                    <div class="card card-default">
                        <div class="card-header">
                            Menus
                        </div> 
                        <div class="card-body">
                            <div id="jstree_menu"></div>


                        </div>   
                    </div>



          </div>
          <div class="col-lg-6">
            <div class="card card-default">
                        <div class="card-header">
                             Menus Event
                        </div> 
                        <div class="card-body">
                            
                          <table class="table table-bordered" id="tb_eventgroups"></table>  

                        </div>   
                    </div>

          </div>

             
  
      </div>
    </div>
  </div>
  
</div>

</div>






@endsection

@section('scripts')
<script>


  var currentSet = [];

  

  


  function saveMenuPerm(){

     var grp_id = jQuery($("#tb_groups tr.active td:nth-child(1)").html()).text()  ;

    if(grp_id ==''){
      toastr.warning('Select Group first', '', {timeOut: 3000});
      return;
    }



            var nodes = $("#jstree_menu").jstree(true).get_selected(true);
            var instance = $('#jstree_menu').jstree(true);
            // var parent = instance.get_parent("#");
            // console.log(parent);

            var arrSet = [];
            



             // var nodes = $('#jstree_menu').jstree("get_selected");

            $.each(nodes,function(i, node){
              // console.log(node.id);
              //  console.log(node.parents.length);
              // if(node.children.length >0){
              //   console.log("not leaf");
              // }
              // else{
              //   console.log("leaf");
              // }  
              var path = [];
              path = instance.get_path(node.id,'',true);
              for (let item of path) {
                // console.log(item); 
                arrSet.push(item);
              }

              // console.log(instance.get_path(node.id,'',true));

              

            });

            var arrMenu = $.unique(arrSet);




            console.log(JSON.stringify(arrMenu));
            console.log(JSON.stringify(currentSet));
            
            // console.log(arr_diff(arrMenu,currentSet));
            var diff = $(arrMenu).not(currentSet).get();
            console.log('add'+JSON.stringify(diff));

            addMenuPerm(diff,grp_id);


            var diff2 = $(currentSet).not(arrMenu).get();
            console.log('del'+JSON.stringify(diff2));

            delMenuPerm(diff2,grp_id);
            
            


            
           


            // var param = { grouproles_id : grp_id
            //               };

            //                       //ajax
            //                       $.ajax({
            //                         type: "POST",
            //                         url:  "/authmanager/menugroups/destroy",
            //                         data : param,
            //                         dataType : 'json', 
            //                         success: function( response ) {
                                      
            //                           if(typeof(response.success) != 'undefined' ){
                                      
            //                            addMenuPerm(arrMenu,grp_id);

            //                           }
                                      
                                      

                                      

            //                         }
            //                     });

            //                     //end






          }

  function addMenuPerm(dataArr,grp_id) {


        var arrayLength = dataArr.length;
        var cnt = 0;

        for (var i = 0; i < arrayLength; i++) {
            var param = { grouproles_id : grp_id
                          ,menu_id : dataArr[i]
                          };
            

            //ajax
            $.ajax({
              type: "POST",
              url:  "/authmanager/menugroups/store",
              data : param,
              dataType : 'json', 
              success: function( response ) {
                
                if(typeof(response.success) != 'undefined' ){
                cnt++;
                if(cnt == arrayLength){
                  toastr.info('Menu Permission successfully added', '', {timeOut: 3000});
                }

                }
                
               


              }
          });

          //end


        }

          



          
  }

  function delMenuPerm(dataArr,grp_id) {


        var arrayLength = dataArr.length;
        var cnt = 0;

        for (var i = 0; i < arrayLength; i++) {
            var param = { grouproles_id : grp_id
                          ,menu_id : dataArr[i]
                          };
            

            //ajax
            $.ajax({
              type: "POST",
              url:  "/authmanager/menugroups/destroy",
              data : param,
              dataType : 'json', 
              success: function( response ) {
                
                if(typeof(response.success) != 'undefined' ){
                cnt++;
                if(cnt == arrayLength){
                  toastr.info('Menu Permission successfully removed', '', {timeOut: 3000});
                }

                }
                
               


              }
          });

          //end


        }

          



          
  }


  function loadMenuGroup(id){

    // var arrMenu = [];
     $("#jstree_menu").jstree().deselect_all();

    currentSet = [];


    //loaddetl
      $.ajax({
        type: "GET",
        url:  "/authmanager/menugroups/show/"+ id,
        dataType : 'json', 
        success: function( response ) {
          $.each(response, function (i, item) {

            currentSet.push(item.menu_id);

              
          });
          console.log('curr:' + currentSet);

          $("#jstree_menu").jstree().select_node(currentSet);


          


        }
    });

    //end

  }

  function initEventGroup(){

    console.log('init');
    

                    

                    $('#tb_eventgroups').bootstrapTable({  
                      pagination : true, //True to show a pagination toolbar on table bottom
                      // url:  "/authmanager/eventmenugroups/show/G1/M9",
                      columns :[
                      {
                            title:'ch',
                            field:'state',
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
                            field:'menu_id',
                            visible:false
                          },
                          {
                            title:'ID',
                            field:'event_id',
                            visible:false
                          },
                          {
                            title:'Event Name',
                            field:'event_nm',
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


                    $('#tb_eventgroups').on('check.bs.table', function (row, $element) {
                          console.log('check');
                          console.log(JSON.stringify($element));
                                  //ajax
                                  $.ajax({
                                    type: "POST",
                                    url:  "/authmanager/eventmenugroups/store",
                                    data : $element,
                                    dataType : 'json', 
                                    success: function( response ) {
                                      
                                      if(typeof(response.success) != 'undefined' ){
                                      toastr.info(response.success, '', {timeOut: 3000});
                                      }
                                      
                                      if(typeof(response.error) != 'undefined' ){
                                      toastr.warning(response.error, '', {timeOut: 3000});
                                      }

                                      


                                    }
                                  });

                                  //end

                        });

                    $('#tb_eventgroups').on('uncheck.bs.table', function (row, $element) {
                          console.log('uncheck');
                          console.log(JSON.stringify($element));
                          //ajax
                                  $.ajax({
                                    type: "POST",
                                    url:  "/authmanager/eventmenugroups/destroy",
                                    data : $element,
                                    dataType : 'json', 
                                    success: function( response ) {
                                      
                                      if(typeof(response.success) != 'undefined' ){
                                      toastr.info(response.success, '', {timeOut: 3000});
                                      }
                                      
                                      if(typeof(response.error) != 'undefined' ){
                                      toastr.warning(response.error, '', {timeOut: 3000});
                                      }

                                      


                                    }
                                  });

                                  //end

                        });

                        
          
                }

  


  function loadEventGroup(id){

    console.log('load');
    

                    // $('#tb_usergroups tbody > tr').remove();
                    var grp_id = jQuery($("#tb_groups tr.active td:nth-child(1)").html()).text()  ;


                    $('#tb_eventgroups').bootstrapTable('destroy');
                    

                    $('#tb_eventgroups').bootstrapTable({  
                      pagination : true, //True to show a pagination toolbar on table bottom
                      url:  "/authmanager/eventmenugroups/show/"+grp_id+"/"+ id,
                      columns :[
                      {
                            title:'ch',
                            field:'state',
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
                            field:'menu_id',
                            visible:false
                          },
                          {
                            title:'ID',
                            field:'event_id',
                            visible:false
                          },
                          {
                            title:'Event Name',
                            field:'event_nm',
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


                    

                        
          
   }

               

  
$(document).ready(function() {



          initEventGroup();



          document.getElementById("group_permission").className = "active";
            
                            // var dataSelect = '{"view": "View Only", "admin": "admin"}';

                            //action groups clicked

                            $('#tb_groups').on('click', '.clickable-row', function(event) {
                              $(this).addClass('active').siblings().removeClass('active');
                              var grp_id = $("#tb_groups tr.active td:nth-child(1)").html();
                              loadMenuGroup(jQuery(grp_id).text());

                              $('#tb_eventgroups').bootstrapTable('destroy');
                    


                              

                              


                            });

                  


                            $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                    }
                            });
                            


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




                          


                            $('#jstree_menu').jstree({
                                  'core': {
                                      'data': {
                                          "url": "/authmanager/treesmenu/all"
                                      }
                                      

                                  },
                                  "checkbox": {
                                      'visible': true,
                                      'keep_selected_style': true, 
                                       // 'whole_node' : false,
                                      // 'tie_selection' : false, 
                                      'three_state':false,
                                  },
                                  "plugins": ["wholerow","checkbox"]
                              }).on('loaded.jstree', function() {
                                $(this).jstree('open_all');
                              });




                             $("#jstree_menu").bind("select_node.jstree", function(e,data){ 
                              var grp_id = jQuery($("#tb_groups tr.active td:nth-child(1)").html()).text()  ;

                              if(grp_id ==''){
                                toastr.warning('Select Group first', '', {timeOut: 3000});
                                return;
                              }
                              

                               loadEventGroup(data.node.id);
                            }); 

                            

                            



            });


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
              loadTrees();
          }

          
      }

      function loadTrees(){
                              //alert();
                              // $('#jstree_menu').jstree().destroy();

                              var system = $('#system').val();

                              
                              //    $('#jstree_menu').jstree(true).settings.core.data.url = "/authmanager/treesmenu/"+system;
                              //    $('#jstree_menu').on('loaded.jstree', function() {
                              //     alert();
                              //   $(this).jstree('open_all');
                              // });
                              //    $('#jstree_menu').jstree(true).refresh();


                              $('#jstree_menu').jstree('destroy');
                              $('#jstree_menu').jstree({
                                  'core': {
                                      'data': {
                                          "url": "/authmanager/treesmenu/"+system
                                          //"dataType": "json" // needed only if you do not supply JSON headers
                                      }
                                  },
                                  "checkbox": {
                                      'visible': true,
                                      'keep_selected_style': true, 
                                       'whole_node' : false,
                                       // 'tie_selection' : false ,
                                      'three_state':false,
                                  },
                                  "plugins": ["wholerow","checkbox"]
                              }).on('loaded.jstree', function() {
                                $(this).jstree('open_all');
                              });
                                 
                                 
                            }

 


    </script>
@endsection

