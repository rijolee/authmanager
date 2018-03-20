                    <input type="text" name="system" id="system" value="all" placeholder="Search system name.." width="100%" onkeypress="handleEnter(this, event)">
                <a href="javascript:goto();" ><span class="glyphicon glyphicon-search"></span></a> 
                

                    <a href="{{route('authmanager.menucreate')}}"  class="form-control btn btn-primary">+ Create New Menu</a>
                    <br>
                    <br>
                    <a href="javascript:addBelow();"  class="form-control btn btn-info">+ Create Menu Below</a>
                    <br>
                    <a href="javascript:del();"  class="form-control btn btn-danger">- Delete Menu</a>
                    <br>
                    <div class="card card-default">
                        <div class="card-header">
                            Menus
                        </div> 
                        <div class="card-body">
                            <div id="jstree_menu"></div>

                        </div>   
                    </div>