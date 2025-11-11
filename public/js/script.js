// Sidebar toggle
const hamburgerBtn = document.getElementById('hamburgerBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

if (hamburgerBtn) {
  hamburgerBtn.addEventListener('click', () => {
    sidebar.classList.add('active');
    sidebarOverlay.classList.add('active');
  });
}

if (sidebarOverlay) {
  sidebarOverlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    sidebarOverlay.classList.remove('active');
  });
}

// Transaction type tabs
const typeTabs = document.querySelectorAll('.type-tab');
const categoryField = document.getElementById('categoryField');
const fromAccountField = document.getElementById('fromAccountField');
const toAccountField = document.getElementById('toAccountField');

typeTabs.forEach((tab) => {
  tab.addEventListener('click', () => {
    typeTabs.forEach((t) => t.classList.remove('active'));
    tab.classList.add('active');

    const type = tab.dataset.type;

    if (type === 'transfer') {
      categoryField.classList.add('d-none');
      fromAccountField.classList.remove('d-none');
      toAccountField.classList.remove('d-none');
    } else {
      categoryField.classList.remove('d-none');
      fromAccountField.classList.add('d-none');
      toAccountField.classList.add('d-none');
    }
  });
});

// Set today's date as default
const eventDateInput = document.getElementById('eventDate');
const today = new Date().toISOString().split('T')[0];
eventDateInput.value = today;

// Form submission
document.getElementById('transactionForm').addEventListener('submit', (e) => {
  e.preventDefault();

  // Close modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('addTransactionModal'));
  modal.hide();

  // Reset form
  e.target.reset();
  eventDateInput.value = today;
});
