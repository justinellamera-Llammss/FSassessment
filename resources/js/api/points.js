import api from "./api";

export function getTodo(userId) {

    console.log(`==== ${userId} ==== `)

    return api.get(`/todo`, {
        params : {
            user_id: userId
        }
    });
}

export function createTodo(todoData) {
    return api.post('/todo', todoData);
}

export function createUser(name ) {
    return api.post('/user', name);
}



