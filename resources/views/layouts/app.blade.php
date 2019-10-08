<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Communications League of Zimbabwe</title>

        <!-- Styles -->        
        <link href="{{ asset('packages/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/bootstrap-4.0.0/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/Select2-4.0.5/css/select2.min.css') }}" rel="stylesheet" type="text/css">        
        <link href="{{ asset('packages/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/Editor-1.7.2/css/editor.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/RowGroup-1.0.2/css/rowGroup.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/Buttons-1.5.1/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/Select-1.2.5/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('packages/FieldType-Select2-1.6.2/editor.select2.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/packages/datatables.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/packages/editor.css') }}" rel="stylesheet" type="text/css">        
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/packages/select2.css') }}" rel="stylesheet" type="text/css">
        @yield('css_files')
    </head>
    <body>
        <nav class="navbar navbar-default sticky-top bg-dark flex-md-nowrap p-0">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('/') }}" >
                <img src={{URL::asset("images/cloz..png")}} alt="Communications League of Zimbabwe"/>                                
            </a>
           
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <!-- <a class="nav-link" href="#">Sign out</a> -->
                    <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </nav>
        <div class="container-fluid">
            <div class="row">
                @include('partials.navigation')
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

                    @yield('content')
                </main>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!-- <script src="{{ asset('packages/datatables.min.js') }}"></script> -->
        <script type="text/javascript" src="{{ asset('packages/vue-2.5.13/vue.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/jQuery-3.2.1/jquery-3.2.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/bootstrap-4.0.0/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/bootstrap-4.0.0/assets/js/vendor/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/Select2-4.0.5/js/select2.min.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('packages/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/Editor-1.7.2/js/dataTables.editor.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/Editor-1.7.2/js/editor.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/RowGroup-1.0.2/js/dataTables.rowGroup.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/Buttons-1.5.1/js/buttons.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/FieldType-Select2-1.6.2/editor.select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/JSZip-2.5.0/jszip.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/Select-1.2.5/js/dataTables.select.min.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
        @yield('js_files')
        <!-- <script type="text/javascript" src="{{ asset('packages/fontawesome-5.0.6/js/fontawesome-all.js') }}"></script> -->
    </body>
</html>
