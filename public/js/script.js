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
