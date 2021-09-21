// Utility functions
function getURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return (sParameterName.length == 1) ? sParameterName[0] :  sParameterName[1];
        }
    }
}

let statusMessages = []

class StatusMessage {

    constructor(name, messages) {
        this.name = name
        this.messages = messages

        this.status = getURLParameter(name + '_status')
        if(this.status != null) {
            this.addMessage(this.status, messages[this.status])
        }
    }

    addMessage(messageName, messageContent) {
        let html = `
        <div id="` + this.name + `-` + messageName + `" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-light">
                    <div class="modal-body">
                        <h5 class="modal-title" id="exampleModalLabel">` + messageContent + `</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;

        $('body').append(html)
        let modalId = '#' + this.name + '-' + messageName

        console.log(messageName)
        $(modalId).modal()
        window.history.replaceState(null, null, window.location.pathname);
    }
}

function addStatusMessage(name, messages) {
    statusMessages.push(new StatusMessage(name, messages));
}