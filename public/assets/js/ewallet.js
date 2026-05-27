function openAddModal() {
    new bootstrap.Modal(document.getElementById('addModal')).show();
}

function closeModal() {
    bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
}

function openEditModal(id, name, phone) {
    document.getElementById('deleteForm').action = '/profile/ewallet/' + id;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

function closeEditModal() {
    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
}

function openEditModal(id, name, phone) {

    document.getElementById('edit_name').value = name;
    document.getElementById('edit_phone').value = phone;

    document.getElementById('editForm').action = '/profile/ewallet/' + id;
    document.getElementById('deleteForm').action = '/profile/ewallet/' + id;

    new bootstrap.Modal(document.getElementById('editModal')).show();
}