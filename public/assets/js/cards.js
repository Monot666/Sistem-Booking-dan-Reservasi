function openAddModal() {
    var modal = new bootstrap.Modal(document.getElementById('addCardModal'));
    modal.show();
}

function openEditModal(id, bankName, accountNumber, cardName) {
    document.getElementById('edit_bank_name').value = bankName;
    document.getElementById('edit_account_number').value = accountNumber;
    document.getElementById('edit_card_name').value = cardName;

    document.getElementById('editCardForm').action = '/profile/cards/' + id;
    document.getElementById('deleteCardForm').action = '/profile/cards/' + id;

    var modal = new bootstrap.Modal(document.getElementById('editCardModal'));
    modal.show();
}