// Booking Page JavaScript Functions - Dropdown Popover Mode

document.addEventListener('DOMContentLoaded', function() {
    initializeDatePicker();
    initializeGuestRoomSelector();
    initializeFormSubmission();
});

// Date Picker Functionality (Flatpickr)
function initializeDatePicker() {
    const dateRangeInput = document.getElementById('date-range');
    if (dateRangeInput && typeof flatpickr !== 'undefined') {
        flatpickr(dateRangeInput, {
            mode: "range",
            dateFormat: "d M Y",
            minDate: "today",
            defaultDate: ["12 Mar 2026", "13 Mar 2026"],
            onReady: function(selectedDates) {
                updateHiddenDates(selectedDates);
            },
            onChange: function(selectedDates) {
                updateHiddenDates(selectedDates);
            }
        });
    }
}

function updateHiddenDates(selectedDates) {
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    if (selectedDates.length === 2 && checkinInput && checkoutInput) {
        checkinInput.value = formatDateISO(selectedDates[0]);
        checkoutInput.value = formatDateISO(selectedDates[1]);
    }
}

// Guest and Room Selector Setup
function initializeGuestRoomSelector() {
    const guestRoomInput = document.getElementById('guest-room');
    if (guestRoomInput) {
        guestRoomInput.addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah penutupan instan saat elemen diklik
            toggleGuestDropdown();
        });
    }

    // Fitur Tambahan: Menutup dropdown secara otomatis jika pengguna mengklik area luar website
    document.addEventListener('click', function(e) {
        const dropdown = document.querySelector('.guest-dropdown');
        const guestRoomInput = document.getElementById('guest-room');
        
        if (dropdown && !dropdown.contains(e.target) && e.target !== guestRoomInput) {
            dropdown.remove();
        }
    });
}

// Fungsi Toggle Pembuat Dropdown Melayang di bawah Input Field
function toggleGuestDropdown() {
    const existingDropdown = document.querySelector('.guest-dropdown');
    if (existingDropdown) {
        existingDropdown.remove();
        return;
    }

    const searchField = document.getElementById('guest-room').closest('.booking-search-field');
    
    // Membaca data counter terakhir agar angka di dropdown sinkron
    const textValue = document.getElementById('guest-room').value;
    const adultsMatched = textValue.match(/(\d+)\s*Adult/);
    const childrenMatched = textValue.match(/(\d+)\s*Child/);
    const roomsMatched = textValue.match(/(\d+)\s*Room/);

    const currentAdults = adultsMatched ? parseInt(adultsMatched[1]) : 2;
    const currentChildren = childrenMatched ? parseInt(childrenMatched[1]) : 0;
    const currentRooms = roomsMatched ? parseInt(roomsMatched[1]) : 1;

    const dropdown = document.createElement('div');
    dropdown.className = 'guest-dropdown';
    dropdown.innerHTML = `
        <div class="dropdown-row">
            <div class="dropdown-label">
                <i class="fa-solid fa-user"></i> Adult
            </div>
            <div class="dropdown-counter">
                <button class="dropdown-btn" type="button" onclick="updateDropdownCount('adults', -1)">-</button>
                <span id="dd-adults-count">${currentAdults}</span>
                <button class="dropdown-btn" type="button" onclick="updateDropdownCount('adults', 1)">+</button>
            </div>
        </div>
        <div class="dropdown-row">
            <div class="dropdown-label">
                <i class="fa-solid fa-users"></i> Children
            </div>
            <div class="dropdown-counter">
                <button class="dropdown-btn" type="button" onclick="updateDropdownCount('children', -1)">-</button>
                <span id="dd-children-count">${currentChildren}</span>
                <button class="dropdown-btn" type="button" onclick="updateDropdownCount('children', 1)">+</button>
            </div>
        </div>
        <div class="dropdown-row">
            <div class="dropdown-label">
                <i class="fa-solid fa-bed"></i> Room
            </div>
            <div class="dropdown-counter">
                <button class="dropdown-btn" type="button" onclick="updateDropdownCount('rooms', -1)">-</button>
                <span id="dd-rooms-count">${currentRooms}</span>
                <button class="dropdown-btn" type="button" onclick="updateDropdownCount('rooms', 1)">+</button>
            </div>
        </div>
        <div class="dropdown-footer">
            <button class="btn-done" type="button" onclick="applyDropdownSelection()">Done</button>
        </div>
    `;

    // Sisipkan dropdown ke dalam kontainer field agar nempel melayang secara absolut
    searchField.appendChild(dropdown);
}

// Fungsi Counter Dropdown
function updateDropdownCount(type, change) {
    const countElement = document.getElementById(`dd-${type}-count`);
    if (countElement) {
        let currentValue = parseInt(countElement.textContent);
        let newValue = currentValue + change;

        const minValues = { adults: 1, children: 0, rooms: 1 };
        const maxValues = { adults: 10, children: 10, rooms: 5 };

        newValue = Math.max(minValues[type], Math.min(maxValues[type], newValue));
        countElement.textContent = newValue;
    }
}

// Menyimpan nilai dari dropdown kembali ke dalam kolom input teks utama website
function applyDropdownSelection() {
    const adults = document.getElementById('dd-adults-count').textContent;
    const children = document.getElementById('dd-children-count').textContent;
    const rooms = document.getElementById('dd-rooms-count').textContent;

    const guestRoomInput = document.getElementById('guest-room');
    if (guestRoomInput) {
        guestRoomInput.value = `${adults} Adult(s), ${children} Child, ${rooms} Room`;
    }

    // Update input hidden untuk keperluan request database landing page
    document.getElementById('guests').value = parseInt(adults) + parseInt(children);
    document.getElementById('rooms').value = rooms;

    // Hapus panel dropdown dari layar
    const dropdown = document.querySelector('.guest-dropdown');
    if (dropdown) dropdown.remove();
}

function initializeFormSubmission() {
    const form = document.getElementById('booking-search-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            handleSearch(this);
        });
    }
}

function handleSearch(formElement) {
    const dateRange = document.getElementById('date-range').value;
    const guestRoom = document.getElementById('guest-room').value;
    const checkinInput = document.getElementById('checkin').value;
    const checkoutInput = document.getElementById('checkout').value;

    if (!dateRange || !guestRoom || !checkinInput || !checkoutInput) {
        alert('Please complete your check-in dates and guest selections.');
        return;
    }

    formElement.submit();
}

function formatDateISO(dateString) {
    const date = new Date(dateString);
    if (Number.isNaN(date.getTime())) return null;
    return date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
}