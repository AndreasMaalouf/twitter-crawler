<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue'

const instruments = ref([])

async function getInstruments() {
    const response = await axios.get('top')

    if (response.status === 200) {
        instruments.value = response.data
        console.log(instruments.value)
    }
}

onMounted(() => {
    getInstruments();
})

</script>

<template>
    <Head title="Top Instruments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Top Instruments</h2>
        </template>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Instrument</th>
                        <th scope="col" class="px-6 py-3">Frequency</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="instrument in instruments" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ instrument.instrument }}</td>
                        <td>{{ instrument.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
