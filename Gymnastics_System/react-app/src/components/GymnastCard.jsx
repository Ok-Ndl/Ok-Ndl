import React from 'react';

export default function GymnastCard({ gymnast, onDelete }) {
  return (
    <article style={{ border: '1px solid #e5e7eb', borderRadius: 14, padding: 14, background: '#fff' }}>
      <h4>{gymnast.full_name}</h4>
      <p>{gymnast.membership_id}</p>
      <p>{gymnast.training_program}</p>
      <button onClick={() => onDelete(gymnast.id)} style={{ marginRight: 8 }}>Delete</button>
    </article>
  );
}
