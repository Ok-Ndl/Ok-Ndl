import React from 'react';

export default function GymnastProfile({ gymnast }) {
  if (!gymnast) return <p>No profile selected.</p>;

  return (
    <article style={{ border: '1px solid #e5e7eb', borderRadius: 14, padding: 14, background: '#fff' }}>
      <h3>{gymnast.full_name}</h3>
      <p>Membership: {gymnast.membership_id}</p>
      <p>Email: {gymnast.email}</p>
      <p>Status: {gymnast.status}</p>
    </article>
  );
}
