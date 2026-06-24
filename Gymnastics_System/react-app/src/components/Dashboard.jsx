import React, { useEffect, useState } from 'react';

export default function Dashboard({ gymnasts }) {
  return (
    <section style={{ display: 'grid', gap: 12 }}>
      <h3>React Dashboard</h3>
      <p>Functional components are used because they are simpler to compose, test, and maintain in modern React apps.</p>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 12 }}>
        <article style={{ background: '#eff6ff', padding: 12, borderRadius: 14 }}>Total: {gymnasts.length}</article>
        <article style={{ background: '#ecfdf5', padding: 12, borderRadius: 14 }}>Active: {gymnasts.filter((item) => item.status === 'ACTIVE').length}</article>
        <article style={{ background: '#fff7ed', padding: 12, borderRadius: 14 }}>Pending: {gymnasts.filter((item) => item.status === 'PENDING').length}</article>
      </div>
    </section>
  );
}
