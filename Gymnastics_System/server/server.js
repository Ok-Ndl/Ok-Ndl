const http = require('http');
const { gymnasts: initialGymnasts } = require('./routes/gymnasts');

let gymnasts = [...initialGymnasts];

const server = http.createServer((req, res) => {
  res.setHeader('Content-Type', 'application/json');
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    res.writeHead(204);
    res.end();
    return;
  }

  const urlParts = req.url.split('/').filter(Boolean);
  if (req.method === 'GET' && urlParts[0] === 'gymnasts') {
    const id = Number(urlParts[1]);
    if (id) {
      const gymnast = gymnasts.find((item) => item.id === id);
      return sendJson(res, gymnast ? 200 : 404, gymnast || { message: 'Not found' });
    }
    return sendJson(res, 200, gymnasts);
  }

  if (req.method === 'POST' && urlParts[0] === 'gymnasts') {
    let body = '';
    req.on('data', (chunk) => { body += chunk; });
    req.on('end', () => {
      const item = JSON.parse(body || '{}');
      const newGymnast = { id: Date.now(), ...item };
      gymnasts.push(newGymnast);
      return sendJson(res, 201, newGymnast);
    });
    return;
  }

  if (req.method === 'PUT' && urlParts[0] === 'gymnasts') {
    const id = Number(urlParts[1]);
    let body = '';
    req.on('data', (chunk) => { body += chunk; });
    req.on('end', () => {
      const update = JSON.parse(body || '{}');
      gymnasts = gymnasts.map((item) => item.id === id ? { ...item, ...update } : item);
      return sendJson(res, 200, gymnasts.find((item) => item.id === id));
    });
    return;
  }

  if (req.method === 'DELETE' && urlParts[0] === 'gymnasts') {
    const id = Number(urlParts[1]);
    gymnasts = gymnasts.filter((item) => item.id !== id);
    return sendJson(res, 200, { message: 'Deleted' });
  }

  return sendJson(res, 404, { message: 'Route not found' });
});

function sendJson(res, statusCode, data) {
  res.writeHead(statusCode);
  res.end(JSON.stringify(data));
}

server.listen(3001, () => console.log('Node simulation running on http://localhost:3001'));
