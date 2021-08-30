// Run code when document is fully loaded
$(document).ready(function() {

    // ---------- Editable Table ----------

    // Setup each editable field
    const POST_URL = 'lib/admin/user_edit.php'
    
    // Student Number
    $('.user-student-number').each((i, obj) => {
        $(obj).editable({
            name: 'student_number',
            type: 'number',
            min: 0,
            title: 'Numéro d\'étudiant.e',
            url: POST_URL
        })
    })

    // User Name
    $('.user-username').each((i, obj) => {
        $(obj).editable({
            name: 'username',
            type: 'text',
            title: 'Nom de l\'utilisateurice',
            url: POST_URL
        })
    })

    // User BDLC Member
    $('.user-bdlc-member').each((i, obj) => {
        $(obj).editable({
            name: 'bdlc_member',
            type: 'checklist',
            title: 'Adhérent.e au BDLC',
            placement: 'right',
            source: {'1': 'enabled'},
            url: POST_URL,
            isSingle: true,
            showbuttons: false,
            mode: 'inline',
            onblur: 'submit',
            display: (value) => {
                $(obj).text((value[0] == '1') ? 'Oui' : 'Non')
            }
        })
    })

    // User Authorization level
    $('.user-auth-level').each((i, obj) => {
        $(obj).editable({
            name: 'auth_level',
            type: 'select',
            title: 'Niveau d\'autorisation',
            url: POST_URL,
            source: [{'0': 'Étudiant.e'}, {'1': 'Barista'}, {'2': 'Administrateurice'}],
            autotext: 'always'
        })
    })

    // User Credit
    $('.user-credit').each((i, obj) => {
        $(obj).editable({
            name: 'credit',
            type: 'number',
            step: '0.01',
            min: 0,
            title: 'Crédit de l\'utilisateurice',
            url: POST_URL,
            display: (value) => {
                $(obj).text(Number(value).toFixed(2) + ' €')
            }
        })
    })

    // ---------- Validate Form ----------
    $('#add-user-form').validate()

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
        window.history.replaceState(null, null, window.location.pathname);
    }
})