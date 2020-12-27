<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent" style="top: 0px; background: #f5f6fa !important;z-index: 5;">
    <div class="container-fluid">
        <div class="navbar-wrapper" style="min-width: 250px;">
            <div class="navbar-minimize d-inline">
                <button id="minimize-button" class="minimize-sidebar btn btn-link btn-just-icon" rel="tooltip" data-original-title="Sidebar toggle" data-placement="right">
                    <i class="fas fa-outdent visible-on-sidebar-regular"></i>    
                    <i class="fas fa-indent  visible-on-sidebar-mini"></i>
                </button>
            </div>
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="#">{{ $page ?? __('Dashboard') }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">                               
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="avatar-circle" style="float: left">
                            <span class="initials">{{substr(Auth::user()->name, 0, 1)}}</span>
                        </div>                        
                        <div style="float: right;"><b class="caret d-none d-lg-block d-xl-block"></b></div>   
                        <b class="caret d-none d-lg-block d-xl-block"></b>                        
                    </a>
                    <ul class="dropdown-menu dropdown-navbar" style="left: -80px;">                        
                        <li class="nav-link">
                            <a id="version_link" href="#" class="nav-item dropdown-item">About</a>
                        </li>
                        <li class="nav-link">
                            <a href="{{ route('password.request') }}" class="nav-item dropdown-item">Reset Password</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="nav-link">
                            <a href="#" class="nav-item dropdown-item" onclick="document.getElementById('logout-form').submit();">Log out</a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>                    
                </li>
                <li class="separator d-lg-none"></li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="{{ __('SEARCH') }}">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>
    </div>
</div>
