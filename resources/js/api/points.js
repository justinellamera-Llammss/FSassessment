import api from "./api";

export function getTodo() {
    return api.get('/');
}

export function createTodo(todoData) {
    return api.post('/appendTodo', todoData);
}

export function createTodoUser( userData ) {
    return api.post('/user', userData);
}

