// Run code when document is fully loaded
$(document).ready(function() {

    // ---------- Editable Table ----------

    // Setup each editable field
    const POST_URL = 'lib/admin/barista_edit.php'
    
    // Barista Class
    $('.barista-class').each((i, obj) => {
        $(obj).editable({
            name: 'class',
            type: 'text',
            title: 'Classe',
            url: POST_URL,
            success: function(response, newValue) {
                console.log(newValue)
                console.log(response)
            }
        })
    })

    // Barista Photo
    $('.barista-photo').each((i, obj) => {
        $(obj).editable({
            name: 'image',
            type: 'file',
            buttonLabel: 'Parcourir',
            allowDelete: false,
            title: 'Photo',
            url: POST_URL,
            display: function(value, response) {
                if(response) {
                    $(obj).text(response.name)
                }
            }
        })
    })

    // ---------- Validate Form ----------
    $('#add-product-form').validate({
        rules: {
            image: {
                required: true,
                extension: "jpg|png|svg"
            }
        }
    })

    // ---------- Status Messages ----------
    addStatusMessage('add', {
        'success' : 'Le.la barista a bien été ajouté !',
        'error' : 'Il y a eu un problème lors de l\'ajout de le.la barista.'
    })

    addStatusMessage('delete', {
        'success': 'Le.la barista a bien été supprimé.',
        'error': 'Il y a eu un problème lors de la suppression du.de la barista.'
    })
})