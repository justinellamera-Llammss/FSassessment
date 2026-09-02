import api from "./api";

export function getTodo() {
    return api.get('/');
}

export function createTodo(todoData) {
    return api.post('/createTodo', todoData);
}

export function createTodoUser( name ) {
    return api.post('/user', name);
}

