<script setup>
import { ref, watchEffect, watch, onMounted } from 'vue';
import { createTodo, createUser, deleteTodo, getTodo, updateTodoStatus, } from '../api/points.js';

const makeTodos = ref('');
const searchByKeyword = ref('');
const md = ref(true);
const at = ref("");
const bkb = ref(null);
const accEdit = ref(false);

const todos = ref([]);

watchEffect(() => {
    console.log(todos.value);
})

const loadTodo = async () => {
    try {
        const res = await getTodo(bkb.value);

        console.log(res);

        todos.value = res.data.data;

        console.log(todos.value);
    } catch (error) {
        console.log(error);
    }
} 


const createMd = async () => {
    try {
        const res = await createUser({
            name: at.value
        });

        bkb.value = res.data.data.id
        // console.log(res.data.data.id);

        await loadTodo();

        md.value = false;
        
        // console.log(res.data.success);
        
    } catch (error) {
        console.log(error);
    }
};


const onSubmitTodo = async () => {
    try {
        const res = await createTodo({
            user_id: bkb.value,
            todo: makeTodos.value
        });

        if (res.data.success) {
            await loadTodo();
        }

    } catch (error) {
        console.log("Error creating Todo", error);
    }
};

const updateStatus = async (todo) => {
    // const newStatus = todo.status === 'pending' ? 'done' : 'pending';
    const newStatus = 'done'
    try {

        const res = await updateTodoStatus(todo, newStatus);

        todo = res.data.data.status;

    } catch (error) {
        console.log(error);
    }
};

const deleteItem = async (item) => {
    try {
        await deleteTodo(item);

        todos.value = todos.value.filter((a) => a.id !== item);
        
    } catch (error) {
        console.log(error);
    }
}


</script>

<template>
    <div class="h-min-auto">
        <div class="w-2xl bg-stone-400 rounded-2xl p-8">
        
            <div v-if="md">
                <div class="w-full">
                    <h1>Type ur name</h1>
                    <input v-model="at" placeholder="name"
                        class="bg-stone-200 rounded-xl p-2 w-full mt-2">
                </div>

                <button 
                    class="p-2 mt-2 bg-stone-200 rounded-md hover:bg-stone-300" 
                    type="submit"
                    v-on:click="createMd"
                >
                    Submit
                </button>
            </div>

            <div v-else>
                <!-- Keyword Search -->
                <div class="w-full">
                    <h1>Search by Keyword</h1>
                    <input v-model="searchByKeyword" placeholder="Keyword Search" class="rounded-xl p-2 bg-stone-200 mt-2">
                </div>

                <form id="form" @submit.prevent="onSubmitTodo">
                    <!-- <div class="flex flex-col ">

                    </div> -->

                    <!-- Create To do -->
                    <div class="mt-6 flex ">
                        <div class="w-full">
                            <h1>Create Todos</h1>
                            <input v-model="makeTodos" placeholder="Create your todos"
                                class="bg-stone-200 rounded-xl p-2 w-full mt-2">
                        </div>
                    </div>
                    
                    
                    <!-- <div class="mt-6 flex ">
                        <div class="w-full">
                            <h1>Create Todos</h1>
                            <input v-model="makeTodos" placeholder="Create your todos"
                                class="bg-stone-200 rounded-xl p-2 w-full mt-2">
                        </div>
                    </div> -->
                </form> 

                <div class="flex justify-end mt-2">
                    <button form="form" class="p-2 bg-stone-200 rounded-md hover:bg-stone-300" type="submit">
                        Submit
                    </button>
                </div>
            </div>

            <!-- Result -->
            <div 
                class="p-2 border-2 border-stone-600 rounded-xl mt-4 bg-stone-100 max-h-80 overflow-auto">
                <div 
                    class="bg-stone-200 rounded-md p-2 flex mt-2 justify-between"
                    v-for="todo in todos"
                >   
                <div class="flex flex-row gap-2">
                    <h3>{{ todo.todo }}</h3>    
                        <div class="bg-stone-300 text-white px-4 rounded-xl gap-2">
                            
                            {{ todo.status }}
                        </div>
                    </div>

                    <div class="flex flex-row gap-2">
                        <button class="bg-stone-300 text-white px-4 rounded-xl gap-2
                            hover:bg-stone-500
                        "
                            @click="updateStatus(todo.status)"
                        >
                            Done
                        </button>

                        <button class="bg-stone-300 text-white px-4 rounded-xl gap-2
                            hover:bg-stone-500"
                            @click="deleteItem(todo.id)"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>