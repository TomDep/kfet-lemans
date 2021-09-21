// Run code when document is fully loaded
$(document).ready(function() {

    // ---------- Editable Table ----------

    // Setup each editable field
    const POST_URL = 'lib/admin/product_edit.php'
    
    // Product Name
    $('.product-name').each((i, obj) => {
        $(obj).editable({
            name: 'name',
            type: 'text',
            title: 'nom',
            url: POST_URL
        })
    })

    // Product Price
    $('.product-price').each((i, obj) => {
        $(obj).editable({
            name: 'price',
            type: 'number',
            step: '0.01',
            min: 0,
            title: 'Prix',
            url: POST_URL,
            display: (value) => {
                $(obj).text(Number(value).toFixed(2) + ' €')
            }
        })
    })

    // Product Bdlc Price
    $('.product-bdlc-price').each((i, obj) => {
        $(obj).editable({
            name: 'bdlc_price',
            type: 'number',
            step: '0.01',
            min: 0,
            title: 'Prix adhérent',
            url: POST_URL,
            display: (value) => {
                $(obj).text(Number(value).toFixed(2) + ' €')
            }
        })
    })

    // Product Category
    $('.product-category').each((i, obj) => {
        $(obj).editable({
            name: 'category',
            type: 'select',
            autotext: 'always',
            source: [{value: '0', text: 'Boisson chaude'}, {value: '1', text: 'Boisson froide'}, {value: '2', text: 'Snack'}],
            title: 'Catégorie du produit',
            url: POST_URL
        })
    })

    // Product Image
    $('.product-image').each((i, obj) => {
        $(obj).editable({
            name: 'image',
            type: 'file',
            buttonLabel: 'Parcourir',
            allowDelete: false,
            title: 'Image du produit',
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
        'success' : 'Le produit a bien été ajouté !',
        'error' : 'Il y a eu un problème lors de l\'ajout du produit (oups)'
    })

    addStatusMessage('delete', {
        'success': 'Le produit a bien été supprimé',
        'error': 'Il y a eu un problème lors de la suppression du produit'
    })
})