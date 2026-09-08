<script setup>
import { ref, watchEffect, watch, onMounted } from 'vue';
import { createTodo, createUser, deleteTodo, getTodo, updateTodoStatus, editTodo} from '../api/points.js';

const makeTodos = ref(''); 
const searchByKeyword = ref('');


const at = ref("");

// user_id User id is one base is one, If a new todo is created append new value to the ref.
const bkb = ref(1);
const userCreatedUsername = ref("");

const currP = ref(1);
const lP = ref(1);

const todoStatus = ref('all');

const perPage = ref(10);

// Edit todo item
const editItem = ref('');
const editTodoId = ref(null);

const todos = ref([]);

watchEffect(() => {
    // console.log(todos.value);
    console.log(JSON.stringify(todos.value, null, 1));
    // loadTodo();
    // console.log(currP.value);
});


watch(todoStatus, async () => {
    console.log(todoStatus.value);
    currP.value = 1;
    loadTodo();
});

let searchTimeout = null;

watch(searchByKeyword, async() => {
    if (searchTimeout) clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currP.value = 1;
        loadTodo();
    }, 500);
})

watch(perPage, async () => {
    currP.value = 1;
    loadTodo();
})

const loadTodo = async () => {
    try {
        const res = await getTodo(
            bkb.value,
            todoStatus.value,
            searchByKeyword.value,
            currP.value,
            perPage.value
        );

        console.log(res);
        // res.data.data.data lol
        todos.value = res.data.data.data;

        console.log(todos.value);

        currP.value = res.data.data.current_page;
        lP.value = res.data.data.last_page;

    } catch (error) {
            console.error(error);
    }
} 

// Removing this fucntion chaoing it into a one screen apporach only now.
const createMd = async () => {
    try {
        const res = await createUser({
            name: at.value
        });

        bkb.value = res.data.data.id
        // console.log(res.data.data.id);
        userCreatedUsername.value = at.value
        await loadTodo();
        at.value = "";
        
        // console.log(res.data.success);
        
    } catch (error) {
            console.error(error);
    }
};

// Change the await loadTodo not to check if a user.id is provided 
const onSubmitTodo = async () => {
    // await loadTodo();
    
    try {
        const res = await createTodo({
            user_id: bkb.value,
            todo: makeTodos.value
        });

        if (res.data.success) {
            
            makeTodos.value = '';
        }

    } catch (error) {
        console.error(error);
    }
};

const updateStatus = async (todo) => {
    const newStatus = todo.status === 'pending' ? 'done' : 'pending';

    try {
        const res = await updateTodoStatus(todo.id, newStatus);
        todo.status = res.data.data.status;

    } catch (error) {
        console.error(error);
    }
};

const deleteItem = async (item) => {
    try {
        await deleteTodo(item);

        todos.value = todos.value.filter((a) => a.id !== item);
    } catch (error) {
        console.error(error);
    }
}

const startEditing = (todo) => {
    editTodoId.value = todo.id;
    editItem.value = todo.todo;
}

const saveEdit = async () => {
    try {
        const res = await editTodo(
            editTodoId.value,
            editItem.value
        );

        if (res.data.success) {
            const updated = todos.value.find(t => t.id === editTodoId.value);
            if (updated) updated.todo = res.data.data.todo;

            editTodoId.value = null;
            editItem.value = "";
        }
    } catch (error) {
        console.error(error);
    }
}

const cancelEdit = () => {
    editTodoId.value = null;
    editItem.value = "";
}

const nxtPage = () => {
    if (currP.value < lP.value) {
        currP.value++,
        loadTodo()
    }
}

const prevPage = () => {
    if (currP.value > 1) {
        currP.value--,
        loadTodo()
    }
}

onMounted(() => loadTodo())

</script>

<template>
    <div class="h-min-auto">
        <div class="w-2xl max-h-[500px] bg-stone-100 rounded-2xl p-8 border-2 overflow-auto">
            
            <h1 class="text-md">Username : {{  userCreatedUsername }}</h1>
            <div
                class="flex flex-row gap-6 mb-4"
            >
              
                <div class="w-full">

                <input 
                        v-model="at" 
                        placeholder="name"
                         class="bg-stone-200 rounded-xl p-2 w-full mt-2 text-xs focus:outline-none"
                    >
                </div>

                <button 
                    class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white" 
                    type="submit"
                    v-on:click="createMd"
                >  
                    Submit
                </button>
            </div>

            <div>
                <!-- ====== Keyword Search + Per Page  ======-->
                <div class="w-full flex gap-4 items-end">
                    <div class="flex-1">
                        <h1 class="text-xs">Search by Keyword</h1>
                        <input 
                            v-model="searchByKeyword" 
                            placeholder="Keyword Search" 
                            class="rounded-xl p-2 bg-stone-200 mt-2 text-xs w-full">
                    </div>
                    <div>
                        <h1 class="text-xs">Per Page</h1>
                        <select 
                            v-model="perPage"
                            class="rounded-xl p-2 bg-stone-200 mt-2 text-xs"
                        >
                            <option :value="5">5</option>
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                        </select>
                    </div>
                </div>

                <form id="form" @submit.prevent="onSubmitTodo">
                    <!-- Create To do -->
                    <div class="mt-6 flex ">
                        <div class="w-full">
                            <h1 class="text-xs">Create Todos</h1>
                            <input 
                                v-model="makeTodos" 
                                placeholder="Create your todos"
                                class="text-xs bg-stone-200 rounded-xl p-2 w-full mt-2">
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

                <div v-if="editTodoId" class="mt-4 border-orange-300 rounded-xl">
                    <h1 class="text-xs mb-2">Edit Todo</h1>
                    <input 
                        v-model="editItem" 
                        placeholder="Edit your todo"
                        class="text-xs bg-white rounded-xl p-2 w-full border border-orange-300 focus:outline-none"
                    >
                    <div class="flex gap-2 mt-2">
                        <button 
                            class="text-xs bg-orange-500 text-white px-4 py-1 rounded-xl hover:bg-orange-600"
                            @click="saveEdit"
                        >
                            Save
                        </button>
                        <button 
                            class="text-xs bg-stone-400 text-white px-4 py-1 rounded-xl hover:bg-stone-500"
                            @click="cancelEdit"
                        >
                            Cancel
                        </button>
                    </div>
                </div>

                <div class="flex justify-between mt-2">
                    <div class="text-xs">
                        <!-- <h1 class="text-md">Filters</h1> -->
                        <div class="flex gap-2">
                            <button class="
                                bg-orange-500 text-white px-4 py-1 rounded-xl gap-2
                                hover:bg-orange-600 
                            "
                                @click="todoStatus = 'pending'"
                            >
                                Pending
                            </button>

                            <button class="bg-orange-500 text-white px-4 rounded-xl gap-2
                                hover:bg-orange-600"
                                @click="todoStatus = 'done'"
                            >
                                Done
                            </button>

                            <button class="bg-orange-500 text-white px-4 rounded-xl gap-2
                                hover:bg-orange-600"
                                @click="todoStatus = 'all'"
                            >
                                All
                            </button>
                        </div>
                    </div>

                    <button 
                        form="form" 
                        class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white" 
                        type="submit"
                    >
                        Submit
                    </button>
                </div>

                
            <!-- Result -->
                <div 
                    class="
                        p-2 border-2 border-stone-400 rounded-xl mt-4 
                        bg-stone-100 max-h-[150px] overflow-auto"
                    >
                    <div 
                        class="bg-stone-200 rounded-md p-2 flex mt-2 justify-between"
                        v-for="todo in todos"
                    >
                        <div
                            class="flex justify-between w-full items-center"
                        >
                            <div>
                                <div class="text-xs">
                                    <h1>Name: {{ todo.user?.name ?? 'Unknown' }}</h1>
                                </div>
                                <div class="flex flex-row items-center w-[95%]">
                                    <div 
                                        :class="todo.status === 'done' ? 'text-xs line-through pr-2' : 'text-xs pr-2'"
                                    >
                                        <p class="">{{ todo.todo }}</p>
                                    </div>
                                </div>
                                    <div :class="todo.status === 'pending' ? 'w-20 h-4 bg-orange-400 self-left text-xs text-white px-4 rounded-xl gap-2' :
                                        ' bg-orange-600 text-white px-4 rounded-xl w-16 gap-2 h-4 text-xs'
                                        "
                                        >
                                        {{ todo.status }}
                                    </div>
                            </div>

                                <div class="flex flex-row gap-2 text-xs">
                                    <button class="bg-orange-500 h-4 text-white px-4 rounded-xl
                                        hover:bg-orange-600F
                                    "
                                        @click="updateStatus(todo)"
                                    >
                                        {{ todo.status === 'pending' ? 'Done' : 'Undo' }}
                                    </button>

                                    <button class="bg-orange-600 text-white px-4 rounded-xl
                                        hover:bg-red-500 text-xs h-4"
                                        @click="deleteItem(todo.id)"
                                    >
                                        Delete
                                    </button>

                                    
                                    <button class="bg-orange-600 text-white px-4 rounded-xl
                                        hover:bg-red-500 text-xs h-4"
                                        @click="startEditing(todo)"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>   
                </div>
                <div class="flex gap-4 justify-end mt-4">

                    <!-- <button
                        class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white"
                        @click="nxtPage"
                    >
                        Next Page
                    </button> -->

                    <button
                        class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white"
                        @click="prevPage"
                    >
                        Previous Page
                    </button>

                     <button
                        class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white"
                        @click="nxtPage"
                    >
                        Next Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>