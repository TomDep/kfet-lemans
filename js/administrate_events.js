// Run code when document is fully loaded
$(document).ready(function() {

    // ---------- Editable Table ----------

    // Setup each editable field
    const POST_URL = 'lib/admin/event_edit.php'
    
    // Event name
    $('.event-name').each((i, obj) => {
        $(obj).editable({
            name: 'name',
            type: 'text',
            title: 'Nom',
            url: POST_URL,
        })
    })

    // Event image
    $('.event-image').each((i, obj) => {
        $(obj).editable({
            name: 'image',
            type: 'file',
            buttonLabel: 'Parcourir',
            allowDelete: false,
            title: 'Image',
            url: POST_URL,
            display: function(value, response) {
                if(response) {
                    $(obj).text(response.name)
                }
            }
        })
    })

    // ---------- Validate Form ----------
    $('#add-event-form').validate({
        rules: {
            image: {
                required: true,
                extension: "jpg|png|svg"
            }
        }
    })

    // ---------- Status Messages ----------
    addStatusMessage('add', {
        'success' : 'L\'événement a bien été ajouté !',
        'error' : 'Il y a eu un problème lors de l\'ajout de l\'événement...'
    })

    addStatusMessage('delete', {
        'success': 'L\'événement a bien été supprimé.',
        'error': 'Il y a eu un problème lors de la suppression de l\'événement.'
    })
})