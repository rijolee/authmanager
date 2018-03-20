<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>AuthManager</title>

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.5/themes/default/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.css">
    @yield('style')
    <!-- <link href="{{ asset('css/jquery.mobile-1.4.5.min.css') }}" rel="stylesheet">
     --><!-- Scripts -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/jquery.tabledit.min.js')}}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.5/jstree.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- <script src="{{ asset('js/jquery.mobile-1.4.5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
      -->   
    

    
</head>
<body>

@include('authmanager::errors')                   



    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
            	<a class="navbar-brand" href="	">
                    Authority Manager
				</a>


            	<ul class="nav nav-tabs">
				  <li role="presentation" id="menu" name="menu"><a href="{{ url('/authmanager') }}">Menu</a></li>
				  <li role="presentation" id="event_menu" name="event_menu"><a href="{{ url('/authmanager/events') }}">Event/Roles</a></li>
				  <li role="presentation" id="group_menu" name="group_menu"><a href="{{ url('/authmanager/group') }}">Group Roles</a></li>
                  <li role="presentation" id="group_permission" name="group_permission"><a href="{{ url('/authmanager/permission') }}">Group Menu Permission</a></li>
                  
                  
				</ul>
                
				
                
                <!-- <a class="navbar-btn" href="{{ url('/authmanager') }}" style="text-decoration: none">
                    Event/Roles
                </a>
                <a class="navbar-link" href="{{ url('/authmanager') }}" style="text-decoration: none">
                    Menu
                </a>
                <a class="navbar-link" href="{{ url('/authmanager') }}" style="text-decoration: none">
                    GroupRoles
                </a> -->


                

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                    </ul>
                </div>
            </div>
        </nav>
        
        <main class="py-4">

            <div class="container">

            	
            <div class="row">
                @yield('menu_detl')
                    
                
            </div>
            </div>

            </div>


            
        </main> 

    </div>


    <script>

        		@if(Session::has('success'))
		            toastr.success('{{ Session::get('success') }}', '', {timeOut: 3000});
		           
		        @endif

		        @if(Session::has('info'))
		            toastr.info('{{ Session::get('info') }}', '', {timeOut: 3000});
		        @endif	

         	
        


    </script>


    @yield('scripts')

</body>
</html>
