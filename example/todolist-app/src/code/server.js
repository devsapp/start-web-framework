
const express = require('express');
const fs = require('fs');
const path = require('path');
const bodyParser = require('body-parser');

// initial todo list
let todos = [
  {
    id: '123',
    text: 'Go shopping',
    isCompleted: false,
  },
  {
    id: '213',
    text: 'Clean room',
    isCompleted: true,
  },
];

const staticBasePath = path.join('public', 'build');

const app = express();
app.all("/", (req, resp) => {
  resp.setHeader('Content-Type', 'text/html');
  resp.send(fs.readFileSync('./public/build/index.html', 'utf8'));
});

// static js resources
app.all('/*.js', (req, resp) => {
  const filePath = path.join(staticBasePath, req.path);
  resp.setHeader('Content-Type', 'text/javascript');
  resp.send(fs.readFileSync(filePath, 'utf8'));
});

// static css resources
app.all('/*.css', (req, resp) => {
  const filePath = path.join(staticBasePath, req.path);
  resp.setHeader('Content-Type', 'text/css');
  resp.send(fs.readFileSync(filePath, 'utf8'));
});

// static svg resources
app.all('/*.svg', (req, resp) => {
  const filePath = path.join(staticBasePath, req.path);
  resp.setHeader('Content-Type', 'image/svg+xml');
  resp.send(fs.readFileSync(filePath, 'utf8'));
});

// static png resources
app.all('/*.png', (req, resp) => {
  const filePath = path.join(staticBasePath, req.path);
  resp.setHeader('Content-Type', 'image/png');
  resp.send(fs.readFileSync(filePath, 'utf8'));
});

app.all('/manifest.json', (req, resp) => {
  const filePath = path.join(staticBasePath, req.path);
  resp.setHeader('Content-Type', 'application/json');
  resp.send(fs.readFileSync(filePath, 'utf8'));
});

// list api
app.get('/api/listTodos', (req, resp) => {
  resp.send(JSON.stringify(todos));
});

// create api
app.get('/api/createTodo', (req, resp) => {
  const { todo: todoStr } = req.query;
  const todo = JSON.parse(todoStr);
  todos.push({
    id: todo.id,
    text: todo.text,
    isCompleted: todo.isCompleted,
  });
  resp.send(JSON.stringify(todos));
});

// update api
app.get('/api/updateTodo', (req, resp) => {
  const { todo: todoStr } = req.query;
  const targetTodo = JSON.parse(todoStr);
  const todo = todos.find((todo) => todo.id === targetTodo.id);
  if (todo) {
    todo.isCompleted = targetTodo.isCompleted;
    todo.text = targetTodo.text;
  }
  resp.send(JSON.stringify(todos));
});

// remove api
app.get('/api/removeTodo', (req, resp) => {
  const { id } = req.query
  // TODO: Implement methods to filter todos, filtering out item with the same id
  // todos = todos.filter();
  const todosIndex = todos.findIndex((todo) => todo.id === id);
  if (todosIndex !== -1) {
    todos.splice(todosIndex, 1);
  } 
  resp.send(JSON.stringify(todos));
});

module.exports = app;