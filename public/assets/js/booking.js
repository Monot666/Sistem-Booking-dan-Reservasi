// Booking Page JavaScript Functions

document.addEventListener('DOMContentLoaded', function() {
    initializeDatePicker();
    initializeGuestRoomSelector();
    initializeSearchButton();
});

// Date Picker Functionality
function initializeDatePicker() {
    const dateRangeInput = document.getElementById('date-range');

    if (dateRangeInput && typeof flatpickr !== 'undefined') {
        flatpickr(dateRangeInput, {
            mode: "range",
            dateFormat: "d M Y",
            minDate: "today",
            defaultDate: ["12 Mar 2026", "13 Mar 2026"],
            onChange: function(selectedDates, dateStr, instance) {
                // Optional: Add any additional logic when dates change
                console.log('Selected dates:', selectedDates);
            }
        });
    } else if (dateRangeInput) {
        // Fallback if flatpickr is not loaded
        dateRangeInput.addEventListener('click', function() {
            alert('Date picker library not loaded. Please check your internet connection.');
        });
    }
}

// Guest and Room Selector Functionality
function initializeGuestRoomSelector() {
    const guestRoomInput = document.getElementById('guest-room');

    if (guestRoomInput) {
        guestRoomInput.addEventListener('click', function() {
            showGuestRoomModal();
        });
    }
}

// Show guest/room selection modal
function showGuestRoomModal() {
    // Create modal overlay
    const modal = document.createElement('div');
    modal.className = 'guest-room-modal';
    modal.innerHTML = `
        <div class="modal-overlay" onclick="closeGuestRoomModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>Select Guests and Rooms</h3>
                <button class="modal-close" onclick="closeGuestRoomModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="selector-group">
                    <label>Adults</label>
                    <div class="counter">
                        <button class="counter-btn" onclick="updateCount('adults', -1)">-</button>
                        <span id="adults-count">2</span>
                        <button class="counter-btn" onclick="updateCount('adults', 1)">+</button>
                    </div>
                </div>
                <div class="selector-group">
                    <label>Children</label>
                    <div class="counter">
                        <button class="counter-btn" onclick="updateCount('children', -1)">-</button>
                        <span id="children-count">0</span>
                        <button class="counter-btn" onclick="updateCount('children', 1)">+</button>
                    </div>
                </div>
                <div class="selector-group">
                    <label>Rooms</label>
                    <div class="counter">
                        <button class="counter-btn" onclick="updateCount('rooms', -1)">-</button>
                        <span id="rooms-count">1</span>
                        <button class="counter-btn" onclick="updateCount('rooms', 1)">+</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeGuestRoomModal()">Cancel</button>
                <button class="btn btn-primary" onclick="applyGuestRoomSelection()">Apply</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
}

// Close guest/room modal
function closeGuestRoomModal() {
    const modal = document.querySelector('.guest-room-modal');
    if (modal) {
        modal.remove();
    }
}

// Update counter values
function updateCount(type, change) {
    const countElement = document.getElementById(`${type}-count`);
    if (countElement) {
        let currentValue = parseInt(countElement.textContent);
        let newValue = currentValue + change;

        // Set minimum values
        const minValues = { adults: 1, children: 0, rooms: 1 };
        newValue = Math.max(minValues[type], newValue);

        // Set maximum values
        const maxValues = { adults: 10, children: 10, rooms: 5 };
        newValue = Math.min(maxValues[type], newValue);

        countElement.textContent = newValue;
    }
}

// Apply guest/room selection
function applyGuestRoomSelection() {
    const adults = document.getElementById('adults-count').textContent;
    const children = document.getElementById('children-count').textContent;
    const rooms = document.getElementById('rooms-count').textContent;

    const guestRoomInput = document.getElementById('guest-room');
    if (guestRoomInput) {
        guestRoomInput.value = `${adults} Adult(s), ${children} Child, ${rooms} Room`;
    }

    closeGuestRoomModal();
}

// Search Button Functionality
function initializeSearchButton() {
    const searchButton = document.querySelector('.booking-search-button');

    if (searchButton) {
        searchButton.addEventListener('click', function() {
            handleSearch();
        });
    }
}

// Handle search functionality
function handleSearch() {
    const dateRange = document.getElementById('date-range').value;
    const guestRoom = document.getElementById('guest-room').value;
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const guestsInput = document.getElementById('guests');
    const roomsInput = document.getElementById('rooms');

    if (!dateRange || dateRange === '') {
        alert('Please select check-in and check-out dates.');
        return;
    }

    if (!guestRoom || guestRoom === '') {
        alert('Please select guests and rooms.');
        return;
    }

    const dates = parseDateRange(dateRange);
    if (!dates || dates.length !== 2) {
        alert('Please select a valid date range.');
        return;
    }

    const checkin = formatDateISO(dates[0]);
    const checkout = formatDateISO(dates[1]);
    if (!checkin || !checkout) {
        alert('Unable to parse selected dates.');
        return;
    }

    const guestsMatch = guestRoom.match(/(\d+)\s*Adult/);
    const roomsMatch = guestRoom.match(/(\d+)\s*Room/);

    if (!guestsMatch || !roomsMatch) {
        alert('Please select a valid number of guests and rooms.');
        return;
    }

    checkinInput.value = checkin;
    checkoutInput.value = checkout;
    guestsInput.value = guestsMatch[1];
    roomsInput.value = roomsMatch[1];

    document.getElementById('booking-search-form').submit();
}

function parseDateRange(dateRange) {
    const regex = /(\d{1,2}\s+[A-Za-z]+\s+\d{4})/g;
    const matches = [...dateRange.matchAll(regex)].map(match => match[1]);
    if (matches.length === 2) {
        return matches;
    }

    const parts = dateRange.split(/\s*(?:to|-)\s*/i);
    return parts.length === 2 ? parts : null;
}

function formatDateISO(dateString) {
    const date = new Date(dateString);
    if (Number.isNaN(date.getTime())) {
        return null;
    }
    return date.toISOString().split('T')[0];
}

// Utility functions
function formatDate(date) {
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}