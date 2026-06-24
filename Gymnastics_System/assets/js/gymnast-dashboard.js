document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('gymnastSearch');
  const programFilter = document.getElementById('gymnastProgramFilter');
  const statusFilter = document.getElementById('gymnastStatusFilter');
  const cards = Array.from(document.querySelectorAll('.gymnast-card'));
  const detailPanel = document.getElementById('gymnastDetailPanel');

  if (!cards.length) return;

  function updateDetail(card) {
    if (!detailPanel || !card) return;

    detailPanel.innerHTML = `
      <h3>Selected Member</h3>
      <h4>${card.dataset.name}</h4>
      <p><strong>Membership ID:</strong> ${card.dataset.membership}</p>
      <p><strong>Email:</strong> ${card.dataset.email}</p>
      <p><strong>Contact:</strong> ${card.dataset.contact}</p>
      <p><strong>Program:</strong> <span class="badge badge-info">${card.dataset.program}</span></p>
      <p><strong>Status:</strong> <span class="badge badge-secondary">${card.dataset.status}</span></p>
      <p><strong>Date of Birth:</strong> ${card.dataset.dob}</p>
      <p><strong>Enrollment Date:</strong> ${card.dataset.enrollment}</p>
      <a class="feature-link" href="profile.php?id=${card.dataset.id}">Open full profile</a>
    `;
  }

  function applyFilters() {
    const term = (searchInput?.value || '').toLowerCase();
    const program = programFilter?.value || '';
    const status = statusFilter?.value || '';

    cards.forEach((card) => {
      const matchesText = [card.dataset.name, card.dataset.membership, card.dataset.program, card.dataset.status, card.dataset.email].join(' ').toLowerCase().includes(term);
      const matchesProgram = !program || card.dataset.program === program;
      const matchesStatus = !status || card.dataset.status === status;
      card.style.display = matchesText && matchesProgram && matchesStatus ? '' : 'none';
    });
  }

  cards.forEach((card) => {
    card.addEventListener('click', () => {
      cards.forEach((item) => item.classList.remove('selected'));
      card.classList.add('selected');
      updateDetail(card);
    });
  });

  [searchInput, programFilter, statusFilter].forEach((el) => el?.addEventListener('input', applyFilters));
  [programFilter, statusFilter].forEach((el) => el?.addEventListener('change', applyFilters));

  const firstVisible = cards.find((card) => card.style.display !== 'none') || cards[0];
  if (firstVisible) {
    firstVisible.classList.add('selected');
    updateDetail(firstVisible);
  }
});
