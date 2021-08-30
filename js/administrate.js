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

$(document).ready(() => {

    // Setup the validate plugin default options
    $.validator.setDefaults({
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            $(element).removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        }
    })

    // Setup the table filter plugin
    $('.filter').each((i, obj) => $(obj).TableFilter());

    // Setup the table sort plugin
    $('.sortable-table').each((i, obj) => {
        let table = $(obj)

        $('.sortable')
        .prop('title', 'Cliquer pour trier la colonne')
        .each(function(){

            var th = $(this),
                thIndex = th.index(),
                inverse = false;

            th.click(function(){
                table.find('td').filter(function(){
                    return $(this).index() === thIndex;
                }).sortElements(function(a, b){
                    if( $.text([a]) == $.text([b]))
                        return 0;
                    return $.text([a]) > $.text([b]) ? inverse ? -1 : 1 : inverse ? 1 : -1;
                }, function(){
                    // parentNode is the element we want to move
                    return this.parentNode; 
                });

                inverse = !inverse;
            });
        });
    })   
})