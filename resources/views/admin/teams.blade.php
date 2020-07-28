@extends('layouts.app')
@section('js_files')
@include('admin.javascript.teams')
@endsection
@section('content')
<div class="card">
    <div class="card-header">        
        <h5 class="card-title">Teams</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="teams-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Name</th>
                        <th class='dt-cell-left'>Nick Name</th>
                        <th class='dt-cell-left'>Contact Person</th>
                        <th class='dt-cell-left'>Tel No</th>                
                        <th class='dt-cell-left'>Email</th>
                        <th class='dt-cell-left'>Home Colours</th>
                        <th class='dt-cell-left'>Away Colours</th>
                        <th class='dt-cell-left'>Home Ground</th>
                        <th class='dt-cell-center'>Active</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection