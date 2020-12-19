<div class="sidebar">
    <div class="sidebar-wrapper ps ps--active-x">
        <div class="logo">
            <img src="/images/logo_callis.png" alt="logo-here" class="simple-text logo-normal">
        </div>
        <ul class="nav">            
            <li class="{{ ($category ?? ' ') == 'system' ? 'active' : ''}}">
                <a data-toggle="collapse" href="#system">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <p>
                        System
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($category ?? ' ') == 'system' ? 'show' : ''}}" id="system">
                    <ul class="nav">
                        <li class="{{ ($page_slug ?? ' ') == 'seasons' ? 'active' : ''}}">
                            <a href="{{route('admin.seasons')}}">

                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Seasons </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'league_formats' ? 'active' : ''}}">
                            <a href="{{route('admin.leagues.formats')}}">

                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> League Formats </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'leagues' ? 'active' : ''}}">
                            <a href="{{route('admin.leagues')}}">

                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Leagues </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'teams' ? 'active' : ''}}">
                            <a href="{{route('admin.teams')}}">

                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Teams </span>
                            </a>
                        </li>    
                        <li class="{{ ($page_slug ?? ' ') == 'players' ? 'active' : ''}}">
                            <a href="{{route('admin.players')}}">

                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Players </span>
                            </a>
                        </li>    

                    </ul>
                </div>
            </li>
            <li class="{{ ($category ?? ' ') == 'matchday' ? 'active' : ''}}">
                <a data-toggle="collapse" href="#matchday">
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                    <p>
                        Match Center
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($category ?? ' ') == 'matchday' ? 'show' : ''}}" id="matchday">
                    <ul class="nav"> 
                        <li class="{{ ($page_slug ?? ' ') == 'match_days' ? 'active' : ''}}">
                            <a href="{{route('admin.match_days')}}">
                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Match Days </span>
                            </a>
                        </li>
                        <li class="{{ ($page_slug ?? ' ') == 'fixtures' ? 'active' : ''}}">
                            <a href="{{route('admin.fixtures')}}">
                                <span class="sidebar-mini-icon"><i class="fas fa-archive"></i></span>
                                <span class="sidebar-normal"> Fixtures </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>            
            <li class="{{ ($category ?? ' ') == 'news' ? 'active' : ''}}">
                <a href="{{route('admin.news')}}">
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
