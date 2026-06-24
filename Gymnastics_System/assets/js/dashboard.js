document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const programFilter = document.getElementById('programFilter');
  const statusFilter = document.getElementById('statusFilter');
  const sortBy = document.getElementById('sortBy');
  const tableBody = document.getElementById('gymnastTableBody');

  if (!tableBody) return;

  const rows = Array.from(tableBody.querySelectorAll('tr'));

  function applyFilters() {
    const term = (searchInput?.value || '').toLowerCase();
    const program = programFilter?.value || '';
    const status = statusFilter?.value || '';
    const sort = sortBy?.value || 'name';

    rows.forEach((row) => {
      const content = row.textContent.toLowerCase();
      const rowProgram = row.dataset.program || '';
      const rowStatus = row.dataset.status || '';
      const matches = content.includes(term) && (!program || rowProgram === program) && (!status || rowStatus === status);
      row.style.display = matches ? '' : 'none';
    });

    const visibleRows = rows.filter(row => row.style.display !== 'none');
    const sorted = [...visibleRows].sort((a, b) => {
      const aValue = a.dataset[sort] || '';
      const bValue = b.dataset[sort] || '';
      return aValue.localeCompare(bValue);
    });

    sorted.forEach((row) => tableBody.appendChild(row));
  }

  [searchInput, programFilter, statusFilter, sortBy].forEach((el) => el?.addEventListener('input', applyFilters));
  [programFilter, statusFilter, sortBy].forEach((el) => el?.addEventListener('change', applyFilters));
});
