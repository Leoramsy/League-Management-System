<div class="sidebar">
    <div class="sidebar-wrapper ps ps--active-x">
        <div class="logo">
            <img src="/images/oilstar-white-logo.png" class="simple-text logo-normal">
        </div>
        <ul class="nav">            
            <li class="{{ ($category ?? ' ') == 'system' ? 'active' : ''}}">
                <a data-toggle="collapse" href="#system">
                    <i class="fas fa-sync-alt"></i>
                    <p>
                        System
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse  show" id="system">
                    <ul class="nav">
                        <li class="{{ ($page_slug ?? ' ') == 'teams' ? 'active' : ''}}">
                            <a href="{{route('admin.teams')}}">

                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Teams </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'results' ? 'active' : ''}}">
                            <a href="{{route('match-centre', ['type' => 'results'])}}">
                                <span class="sidebar-mini-icon">PA</span>
                                <span class="sidebar-normal"> Results </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'logs' ? 'active' : ''}}">
                            <a href="{{route('match-centre', ['type' => 'logs'])}}">
                                <span class="sidebar-mini-icon">PI</span>
                                <span class="sidebar-normal"> Standings </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'live' ? 'active' : ''}}">
                            <a href="{{route('match-centre', ['type' => 'live'])}}">
                                <span class="sidebar-mini-icon">RA</span>
                                <span class="sidebar-normal"> Live Matches </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'statistics' ? 'active' : ''}}">
                            <a href="{{route('match-centre', ['type' => 'statistics'])}}">
                                <span class="sidebar-mini-icon">RO</span>
                                <span class="sidebar-normal"> Statistics </span>
                            </a>
                        </li>                        
                    </ul>
                </div>
            </li>

            <li class="{{ ($category ?? ' ') == 'dashboard' ? 'active' : ''}}">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Tournaments</p>
                </a>
            </li>
            <li class="{{ ($category ?? ' ') == 'dashboard' ? 'active' : ''}}">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Gallery</p>
                </a>
            </li>
            <li class="{{ ($category ?? ' ') == 'dashboard' ? 'active' : ''}}">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>News</p>
                </a>
            </li>            
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
            </div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 879px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 840px;">
            </div>
        </div>
    </div>
</div>
