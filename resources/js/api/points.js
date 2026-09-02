import api from "./api";

export function getTodo() {
    return api.get('/');
}

export function createTodo(data) {
    return api.put('/create', data)
}