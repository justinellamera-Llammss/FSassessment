import api from "./api";

export function getTodo(userId) {
    return api.get(`/todo`, {
        params: {
            user_id: userId
        }
    });
}

export function createTodo(todoData) {
    return api.post('/todo', todoData);
}

export function createUser(name) {
    return api.post('/user', name);
}

export function updateTodoStatus(todoId, status) {
    return api.patch(`/todo/${todoId}`, {
        status: status
    })
}

export function deleteTodo(todoId) {
    return api.delete(`/todo/${todoId}`)
}

export function filterTodo(filter) {
    return api.patch('/todo', {
        status: filter
    });
}

