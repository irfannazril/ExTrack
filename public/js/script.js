// Sidebar toggle
const hamburgerBtn = document.getElementById('hamburgerBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const sidebarCloseBtn = document.getElementById('closeSidebar');

//close sidebar when clicking x button
if (sidebarCloseBtn) {
  sidebarCloseBtn.addEventListener('click', () => {
    sidebar.classList.remove('active');
    sidebarOverlay.classList.remove('active');
  });
}

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

// Add Transaction Button (index.php)
document.addEventListener('DOMContentLoaded', function () {
  const urlParams = new URLSearchParams(window.location.search);
  const action = urlParams.get('action');

  if (action === 'add') {
    // Buka modal
    const addTransactionModal = new bootstrap.Modal(document.getElementById('addTransactionModal'));
    addTransactionModal.show();

    // Hapus parameter dari URL setelah modal dibuka (agar URL bersih)
    // Ini optional, bisa dihapus jika ingin parameter tetap ada
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});

//Transaction type tab
const typeRadios = document.querySelectorAll('.type-tab-radio');
const typeLabels = document.querySelectorAll('.type-tab');
const categoryField = document.getElementById('categoryField');
const fromAccountField = document.getElementById('fromAccountField');
const toAccountField = document.getElementById('toAccountField');
const dateField = document.getElementById('eventDate');

function applyTypeUI(type) {
  if (type === 'transfer') {
    categoryField.classList.add('d-none');
    fromAccountField.classList.remove('d-none');
    toAccountField.classList.remove('d-none');
  } else {
    categoryField.classList.remove('d-none');
    fromAccountField.classList.add('d-none');
    toAccountField.classList.add('d-none');
  }
}

typeRadios.forEach((radio) => {
  radio.addEventListener('change', () => {
    // remove active from all labels
    typeLabels.forEach((l) => l.classList.remove('active'));
    // add active to the label that references this radio
    const lbl = document.querySelector(`label[for="${radio.id}"]`);
    if (lbl) lbl.classList.add('active');

    const type = radio.dataset.type;
    applyTypeUI(type);
  });
});

// Set initial active label & UI based on checked radio (if any)
const initial = document.querySelector('.type-tab-radio:checked') || document.querySelector('.type-tab-radio.active');
if (initial) {
  const initLabel = document.querySelector(`label[for="${initial.id}"]`);
  if (initLabel) initLabel.classList.add('active');
  applyTypeUI(initial.dataset.type);
}

// Set current date as default in date field
if (dateField) {
  const today = new Date().toISOString().split('T')[0];
  dateField.value = today;
}

// Edit Category Function
function editCategory(name, icon) {
  const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
  document.getElementById('editCategoryName').value = name;
  document.getElementById('editCategoryIcon').value = icon;
  editModal.show();
}

// Delete Category Function
function deleteCategory(name) {
  if (confirm(`Are you sure you want to delete "${name}" category?`)) {
    alert(`Category "${name}" deleted successfully!`);
    // Add your delete logic here
  }
}

// Add Category Form Submit
document.getElementById('addCategoryForm').addEventListener('submit', (e) => {
  e.preventDefault();
  const name = document.getElementById('categoryName').value;
  const icon = document.getElementById('categoryIcon').value;

  alert(`Category "${name}" with icon "${icon}" added successfully!`);

  // Reset form
  e.target.reset();

  // Close modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
  modal.hide();
});

// Edit Category Form Submit
document.getElementById('editCategoryForm').addEventListener('submit', (e) => {
  e.preventDefault();
  const name = document.getElementById('editCategoryName').value;
  const icon = document.getElementById('editCategoryIcon').value;

  alert(`Category updated to "${name}" with icon "${icon}"!`);

  // Close modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'));
  modal.hide();
});
