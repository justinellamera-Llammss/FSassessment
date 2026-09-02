<script setup>
import TodoField from '../components/TodoField.vue';
import { ref, watchEffect, watch } from 'vue';
import { createTodo } from '../api/points.js';

const makeTodos = ref('');
const searchByKeyword = ref('');

const todos = ref([]);

const TODO_STATUS = ["Done", "Pending"];

const onSubmit = async () => {
    try {

        const res = await createTodo({
            todo: makeTodos.value
        });
        
        console.log(res);

        makeTodos = "";
    } catch (error) {

        console.log(err);
    }
};  

</script>

<template>
    <div class="h-min-auto">
        <div class="w-2xl bg-stone-400 rounded-2xl p-8">
            <form id="form" @submit.prevent="onSubmit">
                <div class="flex flex-col ">

                    <!-- Keyword Search -->
                    <div class="w-full">
                        <h1>Search by Keyword</h1>
                        <input
                            v-model="searchByKeyword"
                            placeholder="Keyword Search"
                            class="rounded-xl p-2 bg-stone-200 mt-2"
                        >
                    </div>
                </div>

                <!-- Create To do -->
                <div class="mt-6 flex ">
                    <div class="w-full">
                        <h1>Create Todos</h1>
                        <input
                            v-model="makeTodos"  
                            placeholder="Create your todos"
                            class="bg-stone-200 rounded-xl p-2 w-full mt-2"
                        >
                    </div>
                </div>
            </form>

            <div class="flex justify-end mt-2">
                <button
                    form="form"
                    class="p-2 bg-stone-200 rounded-md hover:bg-stone-300"
                    type="submit"
                >
                    Submit
                </button>
            </div>

            <!-- Result -->
            <div class="p-2 border-2 border-stone-600 rounded-xl mt-4 bg-stone-100">
                <div class="bg-stone-200 rounded-md p-2 flex">

                    <div class="w-[70%]">
                        Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                        {{  }}
                    </div>

                    <!-- Status -->
                    <div>
                        Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                        Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>