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
    let addStatus = getURLParameter('add_status')
        let deleteStatus = getURLParameter('delete_status')

        if(addStatus != null) {
            if(addStatus == "success") {
                $('#add-success-message').modal()
            } else if(error) {
                $('#add-error-message').modal()
            }
        }

        if(deleteStatus != null) {
            if(deleteStatus == "success") {
                $('#delete-success-message').modal()
            } else if(error) {
                $('#delete-error-message').modal()
            }
        }

        if(addStatus || deleteStatus) {
            // Remove the tag from the link
            //window.history.replaceState(null, null, window.location.pathname);
        }
})