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
          <form action="{{route('authmanager.menu.store')}}" method="post">
            {{csrf_field()}}

            <div class="form-group">
                  <label for="menu_id">Menu ID</label>
                  <input type="text" name = "menu_id" id = "menu_id" class="form-control"  readonly>
            </div>
            <div class="form-group">
                  <label for="parent_id">Parent ID</label>
                  <input type="text" name = "parent_id" id = "parent_id" class="form-control" value="{{$parentid}}" readonly>
                  <input type="text" name = "parent_nm" id = "parent_nm" class="form-control" value="{{ \rijolee\AuthManager\Model\Menus::where('menu_id',$parentid)->first()->menu_nm }}" readonly>
            </div>

            <div class="form-group">
                  <label for="menu_nm">Menu Name</label>
                  <input type="text" name = "menu_nm" id = "menu_nm" class="form-control" >
            </div>
            <div class="form-group">
                  <label for="menu_order">Menu Order</label>
                  <input type="text" name = "menu_order" id = "menu_order" value="{{ \rijolee\AuthManager\Model\Menus::where('menu_id',$parentid)->first()->menu_order }}" class="form-control" >
            </div>
            <div class="form-group">
                  <label for="system_nm">System Name</label>
                  <input type="text" name = "system_nm"  id = "system_nm" value="{{ \rijolee\AuthManager\Model\Menus::where('menu_id',$parentid)->first()->system_nm }}" class="form-control" >
            </div>
            <div class="form-group">
                  <label for="url">Url</label>
                  <input type="text" name = "url" id = "url" class="form-control" >
            </div>
            <div class="form-group">
                  <label for="url">Class</label>
                  <input type="text" name = "class" id = "class" class="form-control" >
            </div>

            <div class="form-group">
                  <label for="url">Desc</label>
                  <input type="text" name = "desc" id = "desc" class="form-control" >
            </div>

            <div class="form-group">
                  <label for="disp_yn">Display this menu?</label>
                  <select name="disp_yn" id="disp_yn" class="form-control">
                  
                    <option value="0">
                      Yes
                    </option>

                    <option value="1">
                      No
                    </option>
                  

                  </select>
             </div>

            <div class="form-group">
                  <label for="created_at">Created At</label>
                  <input type="text" name = "created_at" id = "created_at" class="form-control" " readonly>
            </div>

            <div class="form-group">
                  <label for="updated_at">Updated At</label>
                  <input type="text" name = "updated_at" id = "updated_at" class="form-control" " readonly>
            </div>
            






            <div class="form-group">
                  <button class="btn btn-success" type="submit">Save</button>
            </div>



          </form>

        </div>
    </div>
  </div>
  
  
</div>

</div>
@endsection

@section('scripts')
<script>


                   $('#system').val($('#system_nm').val());

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

