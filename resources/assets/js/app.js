var confirmDelete = function(link) {
    var message = confirm('Are you sure you want to delete the '+ link.dataset.title +' feature');
    if( message == true ) {
        return document.getElementById( link.dataset.formName ).submit();
    } else {
        return false;
    }
};
