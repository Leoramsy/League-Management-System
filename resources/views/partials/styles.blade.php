{{-- Template main styling --}}
{!! Html::style('packages/bootstrap-4.2.1/css/bootstrap.css?v='. config('app.css_version')) !!}
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/template') }}/dashboard.css">
{!! Html::style('packages/Select2-4.0.3/css/select2.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('packages/Select2-4.0.3/css/select2-bootstrap.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('css/datatables/jquery.dataTables.min.css?v='. config('app.css_version')) !!}
{!! Html::style('css/datatables/editor.dataTables.min.css?v='. config('app.css_version')) !!}
{!! Html::style('css/datatables/buttons.dataTables.min.css?v='. config('app.css_version')) !!}
{!! Html::style('packages/DateTime-1.0.2/css/dataTables.dateTime.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('css/datatables/datatable.custom.css?v='. config('app.css_version')) !!}
{!! Html::style('css/datatables/editor.custom-form.css?v='. config('app.css_version')) !!}
{!! Html::style('css/datatables/editor.multi-columns.css?v='. config('app.css_version')) !!}
{!! Html::style('packages/font-awesome-4.7.0/css/font-awesome.min.css?v='. config('app.css_version')) !!}
{!! Html::style('css/modal.css?v='. config('app.css_version')) !!}
{!! Html::style('css/custom.css?v='. config('app.css_version')) !!}
@yield('css_files')