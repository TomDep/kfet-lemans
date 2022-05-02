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
                        <h5 class="modal-title">` + messageContent + `</h5>
                        <div id="innerMessage"></div>                        
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

        let innerMessage = `
        <h6>
            Récapitulatif de la commande (<span id="totalAmount"></span> €)
        </h6>
        <ul id="innerMessageList">
            
        </ul>
        `;

        $('#innerMessage').append(innerMessage);

        // Add all items
        let totalPrice = 0;
        for (let i = 0; i < sessionStorage.length; i++) {
            let key = sessionStorage.key(i)
            let item = JSON.parse(sessionStorage.getItem(key))

            totalPrice += item.price * item.quantity

            addItem(item.id, item.name, item.quantity, item.price)
        }

        $('#totalAmount').append(totalPrice.toFixed(2));

        $(modalId).modal()
        window.history.replaceState(null, null, window.location.pathname);

        // Specific case for success order
        if(messageName === "success_order" || messageName === "cacolac_1" || messageName === "cacolac_2") {
            // Clear the session storage
            sessionStorage.clear();
        }
    }
}

function addStatusMessage(name, messages) {
    statusMessages.push(new StatusMessage(name, messages));
}

function addItem(id, name, quantity, price) {
    let item = `
        <li id="order-item-` + id + `" class="list-group-item">
            <span class="badge badge-pill" style="background-color: #ff8c00;">` + quantity + `</span>
            <span class="ml-2">` + name + `</span>
            
            <span class="float-right">` + (quantity * price).toFixed(2) + ` €</span>
    
            <input type="number" name="` + id + `" value="` + quantity + `" hidden>
        </li>
        `;

    $('#innerMessageList').append(item);
}