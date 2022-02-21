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

    // User activated
    $('.user-activated').each((i, obj) => {
        $(obj).editable({
            name: 'activated',
            type: 'checklist',
            title: 'Compte activé',
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

    // ---------- Validate Form ----------
    $('#add-user-form').validate()

    // ---------- Status Messages ----------
    addStatusMessage('add', {
        'success' : 'L\'utilisateurice a bien été ajouté !',
        'error' : 'Il y a eu un problème lors de l\'ajout de l\'utilisateurice ... (oups)',
        'user_already_exists' : 'L\'utilisateurice existe déjà !'
    })

    addStatusMessage('delete', {
        'success': 'L\'utilisateurice a bien été supprimé (de la base de donnée bien entendu)',
        'error': 'Il y a eu un problème lors de la suppression de l\'utilisateurice ... Espérons qu\'iel soit encore en un morceau !'
    })
})