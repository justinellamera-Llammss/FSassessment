import api from "./api";

export function getTodo(userId, status) {
    return api.get(`/todo`, {
        params: {
            user_id: userId,
            status: status
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
