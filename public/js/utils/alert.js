function confirmAlert(title, question, callback) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success', 
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });
        
    swalWithBootstrapButtons.fire({
        title: title,
        text: question,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {
                callback();
            }
    });
}