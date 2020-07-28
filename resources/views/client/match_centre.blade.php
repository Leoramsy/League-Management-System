@extends('layouts.app', ['page' => ucfirst($type), 'page_slug' => $type,'category' => 'match-centre'])
@section('js_files')
@include('client.javascript.match_centre.fixtures')
@include('client.javascript.match_centre.results')
@include('client.javascript.match_centre.statistics')
@include('client.javascript.match_centre.logs')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">            
            <div class="card-header" style="padding: 0px">                  
                <ul class="nav nav-tabs" role="tablist">                        
                    <li role="presentation" class="active col text-center"><a data-toggle="tab" href="#fixtures-tab" >Fixtures<span></span></a></li>
                    <li role="presentation" class="col text-center"><a data-toggle="tab" href="#results-tab" >Results<span></span></a></li>
                    <li role="presentation" class="col text-center"><a data-toggle="tab" href="#log-tab" >Log Standings<span></span></a></li>                
                    <li role="presentation" class="col text-center"><a data-toggle="tab" href="#statistics-tab" >Statistics<span></span></a></li>            
                </ul>
            </div>
            <div class="card-body">  
                <div class="tab-content">                       
                    <div id="fixtures-tab" class="tab-pane fade {{ $type == 'fixtures' ? 'show active' : ''}}">      
                        @include('partials.match_centre.fixtures')
                    </div>                        
                    <div id="results-tab" class="tab-pane fade {{ $type == 'results' ? 'show active' : ''}}">      
                        @include('partials.match_centre.results')
                    </div>                        
                    <div id="log-tab" class="tab-pane fade {{ $type == 'logs' ? 'show active' : ''}}">     
                        @include('partials.match_centre.logs')
                    </div>                
                    <div id="statistics-tab" class="tab-pane fade {{ $type == 'statistics' ? 'show active' : ''}}">     
                        @include('partials.match_centre.statistics')
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection