document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (!form) return;

  form.addEventListener('submit', (event) => {
    const fullName = form.full_name?.value.trim() || '';
    const membershipId = form.membership_id?.value.trim() || '';
    const email = form.email?.value.trim() || '';
    const contact = form.contact_no?.value.trim() || '';

    if (fullName.length < 3) {
      event.preventDefault();
      alert('Full name must be at least 3 characters.');
      return;
    }
    if (!/^[A-Z0-9-]{4,12}$/i.test(membershipId)) {
      event.preventDefault();
      alert('Membership ID must be 4-12 letters, numbers, or hyphens.');
      return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      event.preventDefault();
      alert('Please enter a valid email address.');
      return;
    }
    if (!/^\+?[0-9\-\s]{7,15}$/.test(contact)) {
      event.preventDefault();
      alert('Please enter a valid contact number.');
    }
  });
});
