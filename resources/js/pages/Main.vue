<script setup>
import { ref, watchEffect, watch, onMounted } from 'vue';
import { createTodo, createUser, deleteTodo, getTodo, updateTodoStatus} from '../api/points.js';

const makeTodos = ref('');
const searchByKeyword = ref('');
const md = ref(true);
const at = ref("");


// user_id 
const bkb = ref(null);


const currP = ref(1);
const lP = ref(1);

const todoStatus = ref('all');

const todos = ref([]);

watchEffect(() => {
    // console.log(todos.value);

    
    // console.log(currP.value);
});


watch(todoStatus, async () => {
    console.log(todoStatus.value);
    loadTodo();
});

watch(searchByKeyword, async() => {
    setTimeout(() => {
        // search(searchByKeyword.value);
        loadTodo();
    }, 1000);
})

const loadTodo = async () => {
    try {
        const res = await getTodo(
            bkb.value,
            todoStatus.value,
            searchByKeyword.value,
            currP.value
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
            console.error(error);
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


</script>

<template>
    <div class="h-min-auto">
        <div class="w-2xl max-h-[500px] bg-stone-100 rounded-2xl p-8 border-2">
            <div v-if="md"
            >
                <div class="w-full">
                    <h1 class="text-md">Type your name</h1>
                    <input 
                        v-model="at" 
                        placeholder="name"
                        class="bg-stone-200 rounded-md p-2 w-full mt-2 text-xs focus:outline-none"
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

            <div v-else>
                <!-- Keyword Search -->
                <div class="w-full">
                    <h1 class="text-xs">Search by Keyword</h1>
                    <input 
                        v-model="searchByKeyword" 
                        placeholder="Keyword Search" 
                        class="rounded-xl p-2 bg-stone-200 mt-2 text-xs">
                </div>

                <form id="form" @submit.prevent="onSubmitTodo">
                    <!-- Create To do -->
                    <div class="mt-6 flex ">
                        <div class="w-full">
                            <h1 class="text-xs">Create Todos</h1>
                            <input v-model="makeTodos" placeholder="Create your todos"
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
                            <div class="flex flex-row items-center w-[70%]">
                            {{ console.log(todo) }}
                                    <div 
                                        :class="todo.status === 'done' ? 'text-xs line-through pr-2' : 'text-xs pr-2'"
                                    >
                                        <p class="">{{ todo.todo }}</p>
                                    </div>

                                    <div :class="todo.status === 'pending' ? ' h-4 bg-orange-400 self-left text-xs text-white px-4 rounded-xl gap-2' :
                                        ' bg-orange-600 text-white px-4 rounded-xl gap-2 h-4 text-xs'
                                        "
                                        >
                                        {{ todo.status }}
                                    </div>
                            </div>

                                <div class="flex flex-row gap-2 text-xs">
                                    <button class="bg-orange-500 h-4 text-white px-4 rounded-xl
                                        hover:bg-orange-600
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
                                </div>
                            </div>
                        </div>   
                </div>
                <div class="flex gap-4 justify-end mt-4">

                    <button
                        class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white"
                        @click="nxtPage"
                    >
                        Next Page
                    </button>

                    <button
                        class="p-2 mt-2 text-xs bg-orange-400 rounded-xl hover:bg-orange-600 text-white"
                        @click="prevPage"
                    >
                        Previous Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>