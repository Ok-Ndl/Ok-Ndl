import React, { useState } from 'react';

export default function GymnastForm({ onAdd }) {
  const [form, setForm] = useState({ full_name: '', membership_id: '', email: '', training_program: 'Beginner' });

  function updateField(event) {
    setForm({ ...form, [event.target.name]: event.target.value });
  }

  function submit(event) {
    event.preventDefault();
    onAdd({ ...form, status: 'ACTIVE' });
    setForm({ full_name: '', membership_id: '', email: '', training_program: 'Beginner' });
  }

  return (
    <form onSubmit={submit} style={{ display: 'grid', gap: 8 }}>
      <input name="full_name" placeholder="Full Name" value={form.full_name} onChange={updateField} required />
      <input name="membership_id" placeholder="Membership ID" value={form.membership_id} onChange={updateField} required />
      <input name="email" placeholder="Email" value={form.email} onChange={updateField} required />
      <select name="training_program" value={form.training_program} onChange={updateField}>
        <option>Beginner</option><option>Intermediate</option><option>Advanced</option>
      </select>
      <button type="submit">Add Gymnast</button>
    </form>
  );
}
