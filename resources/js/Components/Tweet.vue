<script setup>

const props = defineProps({
    tweetText: {
        type: String,
        required: true,
    },
    tweetId: {
        type: String,
        required: true,
    },
    tweetHandle: {
        type: String,
        required: true,
    },
    tweetDate: {
        type: String,
        required: true,
    }
});

</script>

<template>
    <div>
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="inline-flex w-full">
                <a :href="'https://twitter.com/' + tweetHandle + '/status/' + tweetId" target="_blank"
                    class="inline-flex items-center text-blue-600 hover:underline">
                    <span>@{{ tweetHandle }}</span>
                </a>
                <p class="ml-10 font-normal text-gray-500 dark:text-gray-400">{{ tweetDate }}</p>
            </div>
            <br />
            <br />
            <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ tweetText }}</p>
        </div>
    </div>
</template>