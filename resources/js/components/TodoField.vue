<script setup>

</script>

<template>
    <!-- Keyword Search -->
    <div class="w-full">
        <h1>Search by Keyword</h1>
        <input v-model="searchByKeyword" placeholder="Keyword Search" class="rounded-xl p-2 bg-stone-200 mt-2">
    </div>

    <form id="form" @submit.prevent="onSubmit">
        <div class="flex flex-col ">

        </div>

        <!-- Create To do -->
        <div class="mt-6 flex ">
            <div class="w-full">
                <h1>Create Todos</h1>
                <input v-model="makeTodos" placeholder="Create your todos"
                    class="bg-stone-200 rounded-xl p-2 w-full mt-2">
            </div>
        </div>


        <div class="mt-6 flex ">
            <div class="w-full">
                <h1>Create Todos</h1>
                <input v-model="makeTodos" placeholder="Create your todos"
                    class="bg-stone-200 rounded-xl p-2 w-full mt-2">
            </div>
        </div>
    </form>

    <div class="flex justify-end mt-2">
        <button form="form" class="p-2 bg-stone-200 rounded-md hover:bg-stone-300" type="submit">
            Submit
        </button>
    </div>
</template>