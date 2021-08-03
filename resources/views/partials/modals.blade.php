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
</div>
<!--  End of Modal Container-->