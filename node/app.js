const express = require('express');
const app = express();
const port = process.env.PORT || 3000;

// Middleware para servir arquivos estáticos
app.use(express.static('public'));

// Exemplo de uma rota básica
app.get('/', (req, res) => {
  res.send('Hello World!');
});

// Iniciar o servidor
app.listen(port, () => {
  console.log(`Servidor Node.js rodando na porta ${port}`);
});
