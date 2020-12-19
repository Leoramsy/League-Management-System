@extends('layouts.app', ['page' => 'News', 'page_slug' => 'news','category' => 'news'])
@section('css_files')
{!! Html::style('packages/quill-1.3.7/css/quill.snow.css') !!}
@endsection
@section('js_files')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
{!! Html::script('js/datatables/editor.quill.js') !!}
@include('admin.javascript.settings.news')
@endsection
@section('content')
<div class="card">    
    <div class="card-body">
        <div class="table-responsive ps">
            <table id="news-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class='dt-cell-left'>Title</th>                       
                        <th class='dt-cell-center'>Active</th>
                        <th class='dt-cell-center'>Featured</th>
                        <th class='dt-cell-center'>Published Date</th>
                        <th class='dt-cell-center'>Article Body</th>
                    </tr>
                </thead>
            </table>
            <div id="news-editor" class="custom-editor">
                <fieldset class="half-set multi-set">
                    <legend><i class="fa fa-user" aria-hidden="true"></i> Article:</legend>                             
                    <div class="col-md-12">
                        <editor-field name="news.title"></editor-field>
                        <editor-field name="news.published_date"></editor-field>
                    </div>                   
                    <div class="col-md-12">
                        <editor-field name="news.active"></editor-field>  
                        <editor-field name="news.featured"></editor-field>  
                    </div>
                </fieldset>   
                <fieldset class="full-set">
                    <div class="col-md-12">
                        <editor-field name="news.content"></editor-field>                                        
                    </div>                    
                </fieldset>
            </div> 
        </div>
    </div>
</div>
@endsection
