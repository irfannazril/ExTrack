// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener('click', function () {
    mobileMenu.classList.toggle('active');
    const icon = this.querySelector('i');
    icon.classList.toggle('bi-list');
    icon.classList.toggle('bi-x');
  });
}

// Close mobile menu when clicking on a link
const mobileLinks = document.querySelectorAll('.mobile-link');
mobileLinks.forEach((link) => {
  link.addEventListener('click', function () {
    mobileMenu.classList.remove('active');
    const icon = mobileMenuBtn.querySelector('i');
    icon.classList.add('bi-list');
    icon.classList.remove('bi-x');
  });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
      });
    }
  });
});

// Navbar background on scroll
window.addEventListener('scroll', function () {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 50) {
    navbar.style.background = 'rgba(10, 10, 10, 0.98)';
  } else {
    navbar.style.background = 'rgba(10, 10, 10, 0.95)';
  }
});
