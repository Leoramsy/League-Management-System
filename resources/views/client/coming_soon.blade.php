@extends('layouts.app', ['page' => ucfirst($type), 'page_slug' => $type, 'category' => '$category'])
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Coming Soon!</div>
            <div class="card-body">
                <p class="text-lead text-light">
                    Sorry, this feature is offline right now as we work to make our site even better. Please, come back later and check what we've been up to.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection


