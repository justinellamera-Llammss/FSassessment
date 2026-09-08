import api from "./api";

export function getTodo(userId, status, search, page = 1, perPage = 10) {
    return api.get(`/todo`, {
        params: {
            user_id: userId,
            status: status,
            search: search,
            page: page,
            per_page: perPage
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

export function editTodo(todo, newTodo) {
    return api.patch(`/todo/editTodo/${todo}`, {
        todo: newTodo
    });    
}