import React, { useEffect, useState } from 'react';
import Dashboard from './components/Dashboard';
import GymnastCard from './components/GymnastCard';
import GymnastProfile from './components/GymnastProfile';
import GymnastForm from './components/GymnastForm';

export default function App() {
  const [gymnasts, setGymnasts] = useState([]);
  const [selected, setSelected] = useState(null);

  // Functional components are preferred here because hooks keep the demo concise and readable.
  useEffect(() => {
    fetch('http://localhost:3001/gymnasts')
      .then((res) => res.json())
      .then((data) => {
        setGymnasts(data);
        setSelected(data[0] || null);
      });
  }, []);

  function handleAdd(newGymnast) {
    setGymnasts((prev) => [...prev, { id: Date.now(), ...newGymnast }]);
  }

  function handleDelete(id) {
    setGymnasts((prev) => prev.filter((item) => item.id !== id));
  }

  return (
    <main style={{ padding: 18, background: '#f5f7fb', minHeight: '100vh' }}>
      <h2>React Enhancement</h2>
      <Dashboard gymnasts={gymnasts} />
      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18, marginTop: 18 }}>
        <section style={{ background: '#fff', padding: 14, borderRadius: 18 }}>
          <GymnastForm onAdd={handleAdd} />
        </section>
        <section style={{ background: '#fff', padding: 14, borderRadius: 18 }}>
          <GymnastProfile gymnast={selected} />
        </section>
      </div>
      <section style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 14, marginTop: 18 }}>
        {gymnasts.map((gymnast) => (
          <button key={gymnast.id} onClick={() => setSelected(gymnast)} style={{ background: 'none', border: '1px solid #dbe3ef', borderRadius: 14, padding: 10, cursor: 'pointer' }}>
            <GymnastCard gymnast={gymnast} onDelete={handleDelete} />
          </button>
        ))}
      </section>
    </main>
  );
}
