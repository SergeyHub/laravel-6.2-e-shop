<li id="messagesWidget" class="dropdown fast-actions">
    @include("admin.widgets.messages.content")
</li>

<div id="messagesModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center position-relative">
                <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="h2 modal-title">Сообщения</div>

            </div>
            <div class="modal-body">
                <div class="loader"></div>
            </div>
        </div>
    </div>
</div>
