@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Latest News</div>
            <div class="card-body">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">                        
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="https://dummyimage.com/1500x400/000/fff&text=Test+Image+1" alt="Where is my pic">
                            <div class="carousel-caption d-none d-md-block">
                                <h3>Title 1 goes here</h3>
                                <p>What is this about</p>
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block img-fluid" src="https://dummyimage.com/1500x400/000/fff&text=Test+Image+2" alt="Where is my pic">
                            <div class="carousel-caption d-none d-md-block">
                                <h3>Title 2 goes here</h3>
                                <p>What is this about</p>
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block img-fluid" src="https://dummyimage.com/1500x400/000/fff&text=Test+Image+3" alt="Where is my pic">
                            <div class="carousel-caption d-none d-md-block">
                                <h3>Title 3 goes here</h3>
                                <p>What is this about</p>
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
            <div class="card-header">Match Centre</div>
            <div class="card-body">                
                <ul id="dashboard-match-center" class="col-md-12 nav nav-tabs nav-justified tabbed-nav">                        
                    <li role="presentation" class="active"><a data-toggle="tab" href="#fixtures-tab">Fixtures<span></span></a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#results-tab">Results <span></span></a></li>                       
                    <li role="presentation" class=""><a data-toggle="tab" href="#log-tab">Log Standings<span></span></a></li>                        
                </ul>
                <div class="tab-content row">                       
                    <div id="fixtures-tab" class="tab-pane fade show active">      
                        Fixtures will go here
                    </div>                        
                    <div id="results-tab" class="tab-pane fade">      
                        Results will go here
                    </div>                        
                    <div id="log-tab" class="tab-pane fade">     
                        Log Standings will go here
                    </div> 

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin-top: 10px;">
        <div class="card">
            <div class="card-header">News</div>
            <div class="card-body">
                News Cards will go here
            </div>
        </div>
    </div>
</div>
@endsection
