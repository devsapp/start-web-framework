import * as React from 'react'
import axios from 'axios';
import { render } from 'react-dom'
import TodoForm from './components/todo-form'
import TodoList from './components/todo-list'
import { TodoInterface } from './interfaces'
import './styles/styles.css'


const TodoListApp = () => {
  const [todos, setTodos] = React.useState<TodoInterface[]>([])

  React.useEffect(() => {
    axios.get(`api/listTodos`).then(resp => {
      if (resp.data) {
        setTodos(resp.data);
      }
    })
  }, []);


  function handleTodoCreate(todo: TodoInterface) {
    axios.get(`api/createTodo?todo=${encodeURIComponent(JSON.stringify(todo))}`).then(resp => {
      if (resp.data) {
        setTodos(resp.data);
      }
    })
  }

  function handleTodoUpdate(event: React.ChangeEvent<HTMLInputElement>, id: string) {
    const newTodosState: TodoInterface[] = [...todos]
    const todo = newTodosState.find((todo: TodoInterface) => todo.id === id);
    if (!todo) {
      return;
    }
    todo.text = event.target.value;
    axios.get(`api/updateTodo?todo=${encodeURIComponent(JSON.stringify(todo))}`).then(resp => {
      if (resp.data) {
        setTodos(resp.data);
      }
    });
  }

  function handleTodoRemove(id: string) {
    axios.get(`api/removeTodo?id=${id}`).then(resp => {
      if (resp.data) {
        setTodos(resp.data);
      }
    });
  }

  function handleTodoComplete(id: string) {
    const newTodosState: TodoInterface[] = [...todos]
    const todo = newTodosState.find((todo: TodoInterface) => todo.id === id);
    if (!todo) {
      return;
    }
    todo.isCompleted = !todo.isCompleted;
    axios.get(`api/updateTodo?todo=${encodeURIComponent(JSON.stringify(todo))}`).then(resp => {
      if (resp.data) {
        setTodos(resp.data);
      }
    });
  }

  function handleTodoBlur(event: React.ChangeEvent<HTMLInputElement>) {
    if (event.target.value.length === 0) {
      event.target.classList.add('todo-input-error')
    } else {
      event.target.classList.remove('todo-input-error')
    }
  }

  return (
    <div className="todo-list-app">
      <TodoForm
        todos={todos}
        handleTodoCreate={handleTodoCreate}
      />

      <TodoList
        todos={todos}
        handleTodoUpdate={handleTodoUpdate}
        handleTodoRemove={handleTodoRemove}
        handleTodoComplete={handleTodoComplete}
        handleTodoBlur={handleTodoBlur}
      />
    </div>
  )
}

const rootElement = document.getElementById('root')
render(<TodoListApp />, rootElement)
