const hideModal= ( modalId ) => {
    const myModalEl = document.getElementById( modalId )
    const modal = bootstrap.Modal.getInstance(myModalEl)
    modal.hide();
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}
export {
    hideModal
}