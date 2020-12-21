@extends('layouts.app')
@section('js_files')
@include('client.javascript.home')
@include('client.javascript.dashboard.fixtures')
@include('client.javascript.dashboard.results')
@include('client.javascript.dashboard.logs')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Latest News</div>
            <div class="card-body">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="max-height: 700px">
                    <ol class="carousel-indicators">                        
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="/images/home/image_1.jpg" alt="Where is my pic">
                            <div class="carousel-caption d-none d-md-block">
                                <h3>Preparations for the official launch are underway</h3>                                
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block img-fluid" src="/images/home/image_2.jpg" alt="Where is my pic">
                            <div class="carousel-caption d-none d-md-block">
                                <h3>Preparations for the official launch are underway</h3>                                
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block img-fluid" src="/images/home/image_3.jpg" alt="Where is my pic">
                            <div class="carousel-caption d-none d-md-block">
                                <h3>Preparations for the official launch are underway</h3>                                
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-top: 10px;">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6">Match Centre</div>
                <div class="col-md-6">
                    {!! Form::select('league_id', $leagues, key($leagues), array('id' => 'league-select', 'class' => 'form-control input-original')) !!}
                </div>
            </div>
            <div class="card-body">                
                <ul id="dashboard-match-center" class="col-md-12 nav nav-tabs" style="border-bottom: 2px solid #1B75B9">                        
                    <li role="presentation" class="active"><a data-toggle="tab" href="#fixtures-tab">Fixtures<span></span></a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#results-tab">Results <span></span></a></li>                       
                    <li role="presentation" class=""><a data-toggle="tab" href="#log-tab">Log Standings<span></span></a></li>                        
                </ul>
                <div class="tab-content">                       
                    <div id="fixtures-tab" class="tab-pane fade in active">  
                        <div class="table-responsive ps">
                            <table id="fixtures-table" class="table" style="width: 100%">
                                <thead>
                                    <tr>                                        
                                        <th class='dt-cell-left'>Home Team</th>
                                        <th class='dt-cell-left'>&nbsp;</th>
                                        <th class='dt-cell-left'>Away Team</th> 
                                        <th class='dt-cell-center'>Kick Off</th> 
                                        <th class='dt-cell-center'>&nbsp;</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>                        
                    </div>                        
                    <div id="results-tab" class="tab-pane fade">      
                        <div class="table-responsive ps">
                            <table id="results-table" class="table" style="width: 100%">
                                <thead>
                                    <tr>                                        
                                        <th class='dt-cell-left'>Home Team</th>
                                        <th class='dt-cell-left'>Score</th>
                                        <th class='dt-cell-left'>&nbsp;</th>
                                        <th class='dt-cell-left'>Away Team</th> 
                                        <th class='dt-cell-left'>Score</th> 
                                        <th class='dt-cell-center'>&nbsp;</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>       
                    </div>                        
                    <div id="log-tab" class="tab-pane fade">     
                        <div class="table-responsive ps">
                            <table id="logs-table" class="table" style="width: 100%">
                                <thead>
                                    <tr>            
                                        <th class='dt-cell-center'>Position</th>
                                        <th class='dt-cell-left'>Team</th>
                                        <th class='dt-cell-center'>Played</th>
                                        <th class='dt-cell-center'>Win</th>
                                        <th class='dt-cell-center'>Draw</th> 
                                        <th class='dt-cell-center'>Loss</th> 
                                        <th class='dt-cell-center'>Points</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div> 
                    </div> 

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-top: 10px;">
        <div class="card">
            <div class="card-header">Latest News</div>
            <div class="card-body">
                <h3 style="color: black">All set for the Official Opening Tournament</h3>
                <h6>21 December 2020 by Admin</h6>
                <p>The draw for the opening tournament was made late today in the presence of all team captions. The captains were also taken through the rules of the day so that they can convey this message to their players.</p>
                <p>11 teams will participate in tomorrow's tournament with each team playing 12 minutes for each group game.</p>
            </div>
        </div>
    </div>
</div>
@endsection


