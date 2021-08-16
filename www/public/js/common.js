$(function() {
    /********************************
     * POPUP
     * ******************************/

    //Hide contents when the modal is hidden
    // $(".modal").on("hidden.bs.modal", function () {
    //     //$(this).find('.modal-body').html('');
    // });

    /**********************************
     * TOOLTIPS
     **********************************/

    //FIXME: Not working 
    $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
});