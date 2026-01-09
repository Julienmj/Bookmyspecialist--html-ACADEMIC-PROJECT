// script.js

// Handle Home button
document.getElementById('homeBtn').addEventListener('click', () => {
  window.location.href = 'assets/docs/Documentation.html';
});

// Handle Help button
document.getElementById('helpBtn').addEventListener('click', () => {
  window.location.href = 'assets/docs/help.html';
});

// Handle Admin login
document.getElementById('adminBtn').addEventListener('click', () => {
  window.location.href = 'admin/admin.html';
});

// Admin login function for index.html
function adminLogin() {
  window.location.href = 'admin/admin.html';
}

// Provide feedback when a doctor is selected
document.querySelectorAll('select').forEach(select => {
  select.addEventListener('change', (e) => {
    const selected = e.target.value;
    alert(`You selected: ${selected}`);
  });
});

// =========== New booking modal logic ============

const modal = document.getElementById('userInfoModal');
const nameInput = document.getElementById('userFullName');
const emailInput = document.getElementById('userEmail');
const phoneInput = document.getElementById('userPhone');
const confirmBtn = document.getElementById('confirmBookingBtn');
const cancelBtn = document.getElementById('cancelBookingBtn');

let selectedDepartment = null;
let selectedForm = null;

// Open modal and store which form/department is being booked
function openUserInfoModal(dept) {
  selectedDepartment = dept;
  selectedForm = document.getElementById(dept + 'Form');
  nameInput.value = '';
  emailInput.value = '';
  phoneInput.value = '';
  modal.classList.remove('hidden');
  nameInput.focus();
}

function closeUserInfoModal() {
  modal.classList.add('hidden');
}

// Confirm booking: fill hidden fields and submit the form
confirmBtn.onclick = function() {
  const name = nameInput.value.trim();
  const email = emailInput.value.trim();
  const phone = phoneInput.value.trim();

  if (!name || !email || !phone) {
    alert('Please fill out all fields.');
    return;
  }

  // Fill hidden fields in the selected form
  selectedForm.querySelector('input[name="fullName"]').value = name;
  selectedForm.querySelector('input[name="email"]').value = email;
  selectedForm.querySelector('input[name="phone"]').value = phone;

  // Submit the form
  selectedForm.submit();

  closeUserInfoModal();
};

cancelBtn.onclick = function() {
  closeUserInfoModal();
};

// Book Now button logic
document.querySelectorAll('.book-btn').forEach(button => {
  button.addEventListener('click', (e) => {
    const form = e.target.closest('form');
    const select = form.querySelector('select');
    if (!select.value || select.selectedIndex === 0) {
      alert('Please select a doctor before booking.');
      return;
    }
    openUserInfoModal(button.dataset.dept);
  });
});