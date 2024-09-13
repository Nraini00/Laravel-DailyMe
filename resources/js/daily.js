
function populateEditModal(id) {
    // You can use AJAX to populate the modal form with the selected apparel's data if needed
    // Example:
    $.ajax({
    url: '/apparel/' + id + '/edit',
    method: 'GET',
    success: function(data) {
    $('#editForm-' + id).find('input[name="name"]').val(data.name);
    //         // Populate other fields
    }
    });
}

function confirmDelete(id) {
    return confirm('Are you sure you want to delete this item with ID ' + id + '?');
}

function previewImage() {
    const fileInput = document.getElementById('attachment');
    const preview = document.getElementById('attachmentPreview');

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(fileInput.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}