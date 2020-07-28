<div class="sidebar">
    <div class="sidebar-wrapper ps ps--active-x">
        <div class="logo">
            <img src="/images/oilstar-white-logo.png" class="simple-text logo-normal">
        </div>
        <ul class="nav">
            <li class="{{ ($category ?? ' ') == 'dashboard' ? 'active' : ''}}">
                <a href="/">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ ($category ?? ' ') == 'match-centre' ? 'active' : ''}}">
                <a data-toggle="collapse" href="#movements">
                    <i class="fas fa-sync-alt"></i>
                    <p>
                        Match Centre
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse  show" id="movements">
                    <ul class="nav">
                        <li class="{{ ($page_slug ?? ' ') == 'fixtures' ? 'active' : ''}}">
                            <a href="{{route('match_centre', ['type' => 'fixtures'])}}">
                                
                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Fixtures </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'results' ? 'active' : ''}}">
                            <a href="{{route('match_centre', ['type' => 'results'])}}">
                                <span class="sidebar-mini-icon">PA</span>
                                <span class="sidebar-normal"> Results </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'logs' ? 'active' : ''}}">
                            <a href="{{route('match_centre', ['type' => 'logs'])}}">
                                <span class="sidebar-mini-icon">PI</span>
                                <span class="sidebar-normal"> Standings </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'live' ? 'active' : ''}}">
                            <a href="{{route('match_centre', ['type' => 'live'])}}">
                                <span class="sidebar-mini-icon">RA</span>
                                <span class="sidebar-normal"> Live Matches </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'statistics' ? 'active' : ''}}">
                            <a href="{{route('match_centre', ['type' => 'statistics'])}}">
                                <span class="sidebar-mini-icon">RO</span>
                                <span class="sidebar-normal"> Statistics </span>
                            </a>
                        </li>                        
                    </ul>
                </div>
            </li>
            
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Tournaments</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Gallery</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>News</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Images</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Videos</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Who we are</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>About us</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>League Executive</p>
                </a>
            </li>
            <li class="">
                <a href="#">
                    <i class="fas fa-chart-pie"></i>
                    <p>Contact us</p>
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
