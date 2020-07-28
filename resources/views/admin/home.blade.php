@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Welcome {{auth()->user()->name}}</div>            
        </div>
    </div>
    
</div>
@endsection
