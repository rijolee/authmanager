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
           Please click :
            <br>
          Go, for searching system name for filtering your menu based on your system modul  <br>
          +Create New Menu, for adding a new menu for your system  <br>
          
          +Create New Menu Below, for adding sub menu based on your selected menu (hierarchy)  <br>
          
          -Delete Menu, for remove your menu
            <hr>
          Quick tips:  <br>
          
          Field "menu order" in each menu is ordering the menu hierarchy (eq : 1, 1.1 , 2, 2.1)  <br>
          
          Open Events Accordion Menu for related event/role in every selected menu 


          
          

        </div>
    </div>
  </div>
  
  
</div>
</div>

@endsection

@section('scripts')
<script>

       $(document).ready(function() {


                document.getElementById("menu").className = "active";
                



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
                    top.document.location.href="/authmanager/showmenu/"+ data.selected+'/'+$('#system').val();
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


                        }
                    });
                  }

                           

                });

               //$('#jstree_menu').select_node('MN001');
               //$.jstree.reference('#jstree_menu').select_node('MN001');
               
               //$('#jstree_menu').jstree().settings.core.data = {!! $menus !!};
               //$('#jstree_menu').jstree().refresh();
               
               
               
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
              var system_nm = $('#system').val();
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
              if(selectedData.length > 0)
               top.document.location.href="/authmanager/menu/destroy/"+ selectedData[0];
              else
                toastr.warning('Select menu first', 'Warning', {timeOut: 3000});
            // var sel = $('#jstree_menu').jstree().get_selected(true)[0].text;

            // alert(sel);


        }   


        function goto(){
            
            var system_nm = $('#system').val();
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

