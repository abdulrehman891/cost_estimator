// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {

        Swal.fire({
            text: 'Are you sure you want to remove?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('delete_quotation', this.getAttribute('data-kt-quotation-id'));
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="send_row"]').forEach(function (element) {
    element.addEventListener('click', function () {

        Swal.fire({
            text: 'Are you sure you want to send Proposal?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                //{{ route('qoutation.send', $quotation) }}
                Livewire.emit('send_quotation', this.getAttribute('data-kt-quotation-id'));
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('update_quotation', this.getAttribute('data-kt-quotation-id'));
    });
});

// document.querySelectorAll('[data-kt-action="close_modal"]').forEach(function (element) {
//     element.addEventListener('click', function () {
//         Livewire.emit('close_modal');
//     });
// });
// document.querySelectorAll('[data-kt-action="open_modal"]').forEach(function (element) {
//     element.addEventListener('click', function () {
//         Livewire.emit('open_modal');
//     });
// });

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables['quotations-table'].ajax.reload();
    location.reload();
});
