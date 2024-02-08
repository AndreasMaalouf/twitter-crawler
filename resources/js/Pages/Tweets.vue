<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tweet from '@/Components/Tweet.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue'

const tweets = ref([])

const currentTag = ref('')

const tags = ref(['$BTC', '$AAPL', '$SPY', '$CAT'])

async function getTweets(tag = null) {

    let path = 'tweets/';
    if (tag !== null) {
        currentTag.value = tag
        path += tag
    } else {
        path += 'all'
    }

    const response = await axios.get(path)

    if (response.status === 200) {
        tweets.value = response.data.data
    }
}


onMounted(() => {
    getTweets();
})

</script>

<template>
    <Head title="Tweets" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ tag }}Tweets</h2>
        </template>

        <div class="flex justify-center items-center mt-5 mb-5">
            <div class="inline" v-for="tag in tags">
                <button @click="getTweets(tag)" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{
                        tag }}</button>
            </div>
        </div>

        <div v-for="tweet in tweets" class="inline-block mr-2 ml-2 mt-2 mb-2">
            <Tweet :tweet-text="tweet.tweet_text" :tweet-id="tweet.tweet_id" :tweet-handle="tweet.twitter_handle"
                :tweet-date="tweet.tweet_date"></Tweet>
        </div>
    </AuthenticatedLayout></template>
