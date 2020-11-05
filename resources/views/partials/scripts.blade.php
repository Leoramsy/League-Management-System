{{-- Template main scripts --}}
<script src="{{ asset('js/template') }}/jquery.min.js"></script>
<script src="{{ asset('js/template') }}/popper.min.js"></script>
<script src="{{ asset('js/template') }}/bootstrap.min.js"></script>
<script src="{{ asset('js/template') }}/perfect-scrollbar.jquery.min.js"></script>
<script src="{{ asset('js/template') }}/dashboard.js"></script>
<script src="{{ asset('js/template') }}/chartjs.min.js"></script>
<script src="{{ asset('js/template') }}/bootstrap-notify.js"></script>
{{-- System scripts --}}
@include('partials.post_initiate')
{!! Html::script('js/main.js') !!}
{!! Html::script('packages/Select2-4.0.3/js/select2.min.js') !!}
{!! Html::script('js/datatables/jquery-ui.min.js') !!}
{!! Html::script('js/datatables/jquery.dataTables.min.js') !!}    
{!! Html::script('js/datatables/dataTables.bootstrap.min.js') !!} 
{!! Html::script('js/datatables/dataTables.buttons.min.js') !!}
{!! Html::script('js/datatables/dataTables.select.min.js') !!}
{!! Html::script('js/datatables/dataTables.editor.js') !!}
{!! Html::script('js/datatables/select2.min.js') !!}
{!! Html::script('js/datatables/editor.select2.min.js') !!}
{!! Html::script('js/datatables/moment.min.js') !!}
{!! Html::script('js/datatables/datetime-moment.js') !!}
{!! Html::script('js/inputmask-4.0/min/inputmask/inputmask.min.js') !!}
{!! Html::script('js/inputmask-4.0/min/inputmask/inputmask.extensions.min.js') !!}
{!! Html::script('js/inputmask-4.0/min/inputmask/inputmask.numeric.extensions.min.js') !!}
{!! Html::script('js/inputmask-4.0/min/inputmask/jquery.inputmask.min.js') !!}
{!! Html::script('js/FieldType-Mask-1.5.6/editor.mask.min.js') !!} 
{!! Html::script('js/FieldType-Select2-1.6.2/editor.select2.js') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
{!! Html::script('js/datatables/custom.editor.bootstrap.js') !!}
{{-- Add page specific scripts --}}
@yield('js_files')
