<?php
// Component untuk menampilkan alert
$flash = get_flash();
if ($flash):
?>
<div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
  <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : ($flash['type'] === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
  <?= htmlspecialchars($flash['message']) ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<script>
  // Auto hide alert after 10 seconds
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }
  }, 10000);
</script>
<?php endif; ?>
