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
            <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ tweetText }}</p>
            <a :href="'https://twitter.com/' + tweetHandle + '/status/' + tweetId" target="_blank"
                class="inline-flex items-center text-blue-600 hover:underline">
                <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
                </svg>
            </a>
        </div>
    </div>
</template>