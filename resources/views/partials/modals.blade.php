<div id="overlay-container" class="content-overlay" style="display: none;">
    @yield('specific_modals')
    <!-- Modal -->
    <div id="feedback-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <div id='feedback-error' class='modal-error hide'></div>
                    <button id='feedback-ok' type="submit" class="btn btn-default" data-dismisswithcallback="">Ok</button>
                    <button id='feedback-cancel' type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>  
    @if (Auth::check() && count(Auth::user()->companies) > 1)
    <!-- Modal -->
    <div  id="company-modal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 400px; top: 10%">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal_header_css">                    
                    <div class="col-md-12">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <span style="text-align: center">Select a Company</span>                        
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 10px">
                    <div class="panel-group">
                        @foreach(Auth::user()->companies AS $company)
                        <div class="col-md-12">
                            <div class="col-md-9">
                                <label for="{{ $company->id }}">{{ $company->name }}</label>
                            </div>
                            <div class="col-md-3">
                                <input type="radio" id="{{ $company->id }}" name="companies" value="{{ $company->id }}" {{ $company->id == auth()->user()->company_id ? 'checked' : ''}}/>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer modal_footer_css">
                    <button id="company_modal_submit" onclick="submitCompany()" type="button" class="dt-button buttons-create" data-dismiss="modal">Switch</button>
                    <button id="company_modal_close" type="button" class="dt-button buttons-create" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</div> 
<!--  End of Modal Container-->