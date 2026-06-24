document.addEventListener('DOMContentLoaded', function () {
  const appointmentList = document.getElementById('appointment-list');
  if (!appointmentList) return;

  const items = Array.from(appointmentList.querySelectorAll('li'));
  const filter = document.getElementById('status-filter');

  if (filter) {
    filter.addEventListener('change', function () {
      const selected = this.value;
      items.forEach(function (item) {
        const status = item.dataset.status || 'all';
        item.style.display = (selected === 'all' || status === selected) ? '' : 'none';
      });
    });
  }
});
