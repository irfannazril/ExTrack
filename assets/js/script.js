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

// STATISTIC.PHP
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

// TRANSACTION.PHP
/**
 * Setup UI behavior for a transaction modal (scoped inside the modal element).
 * prefix = 'add' | 'edit' to match element IDs like addCategoryField / editCategoryField
 */
function setupTransactionModal(modalEl, prefix) {
  if (!modalEl) return;
  const radios = modalEl.querySelectorAll('.type-tab-radio');
  const labels = modalEl.querySelectorAll('.type-tab');
  const categoryField = modalEl.querySelector(`#${prefix}CategoryField`);
  const fromField = modalEl.querySelector(`#${prefix}FromAccountField`);
  const toField = modalEl.querySelector(`#${prefix}ToAccountField`);
  const dateField = modalEl.querySelector(`#${prefix}EventDate`);

  function applyTypeUI(type) {
    if (!categoryField || !fromField || !toField) return;
    if (type === 'transfer') {
      categoryField.classList.add('d-none');
      fromField.classList.remove('d-none');
      toField.classList.remove('d-none');
    } else {
      categoryField.classList.remove('d-none');
      fromField.classList.add('d-none');
      toField.classList.add('d-none');
    }
  }

  radios.forEach((r) => {
    r.addEventListener('change', () => {
      // labels inside this modal only
      labels.forEach((l) => l.classList.remove('active'));
      const lbl = modalEl.querySelector(`label[for="${r.id}"]`);
      if (lbl) lbl.classList.add('active');
      applyTypeUI(r.dataset.type);
    });
  });

  // initial
  const initial = modalEl.querySelector('.type-tab-radio:checked');
  if (initial) {
    const initLabel = modalEl.querySelector(`label[for="${initial.id}"]`);
    if (initLabel) initLabel.classList.add('active');
    applyTypeUI(initial.dataset.type);
  }

  // set default date to today if field exists
  if (dateField) {
    const today = new Date().toISOString().split('T')[0];
    dateField.value = today;
  }
}

// initialize both modals
document.addEventListener('DOMContentLoaded', () => {
  setupTransactionModal(document.getElementById('addTransactionModal'), 'add');
  setupTransactionModal(document.getElementById('editTransactionModal'), 'edit');

  // Populate edit modal from the clicked transaction row
  document.querySelectorAll('.menu-button').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      // find closest transaction item
      const item = btn.closest('.transaction-item');
      if (!item) return;
      const amountEl = item.querySelector('.transaction-amount');
      const descEl = item.querySelector('.transaction-description');
      const catEl = item.querySelector('.transaction-category');

      // extract values
      const amountText = amountEl ? amountEl.textContent.trim() : '';
      const isIncome = amountText.startsWith('+');
      const numericAmount = amountText.replace(/[^\d]/g, '') || '';
      const description = descEl ? descEl.textContent.trim() : '';
      const category = catEl ? catEl.textContent.trim().toLowerCase() : '';

      // fill edit modal inputs
      const editAmount = document.getElementById('editAmount');
      const editDescription = document.getElementById('editDescription');
      const editCategory = document.getElementById('editCategory');
      const editEventDate = document.getElementById('editEventDate');

      if (editAmount) editAmount.value = numericAmount;
      if (editDescription) editDescription.value = description;
      if (editCategory) {
        // attempt to set select by matching option text/value
        const opt = Array.from(editCategory.options).find((o) => o.value.toLowerCase() === category || o.text.toLowerCase().includes(category));
        if (opt) {
          editCategory.value = opt.value;
        }
      }
      if (editEventDate) {
        // keep existing date or today's date — optionally parse from item if available
      }

      // set type radio
      const typeId = isIncome ? 'editIncome' : 'editExpense';
      const typeRadio = document.getElementById(typeId);
      if (typeRadio) {
        typeRadio.checked = true;
        // trigger change so UI updates
        typeRadio.dispatchEvent(new Event('change'));
      }

      // show modal
      const editModal = new bootstrap.Modal(document.getElementById('editTransactionModal'));
      editModal.show();
    });
  });
});
