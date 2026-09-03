<script setup>
import TodoField from '../components/TodoField.vue';
import { ref, watchEffect, watch, onMounted } from 'vue';
import { createTodo, createUser, getTodo, } from '../api/points.js';

const makeTodos = ref('');
const searchByKeyword = ref('');
const md = ref(true);
const at = ref("");
const bkb = ref(null);

const todos = ref([]);

watchEffect(() => {
    console.log(at.value);
    console.log(bkb.value);
    console.log(todos.value);
})

const loadToto = async () => {
    try {
        const res = await getTodo(bkb.value);

        todos.value.push(res.data);

    } catch (error) {
        console.log(error)
    };
}

const createMd = async () => {
    // alert("test");

    try {
        const res = await createUser({
            name: at.value
        });

        bkb.value = res.data.data.id
        // console.log(res.data.data.id);
        md.value = false;
        console.log(res.data.success);
        
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

        console.log(res);
    } catch (error) {
        console.log("Error creating Todo", error);
    }
};

onMounted(() => {
    loadToto();
})

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
            <div class="p-2 border-2 border-stone-600 rounded-xl mt-4 bg-stone-100">
                <div class="bg-stone-200 rounded-md p-2 flex">

                    <div class="w-[70%]">
                        Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                        {{ }}
                    </div>

                    <!-- Status -->
                    <div>
                        Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>