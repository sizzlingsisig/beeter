<template>
    <div class="feed-container container mt-5">
        <div
            v-for="tweet in tweets"
            :key="tweet.id"
            class="tweet border-bottom py-4 d-flex"
        >
            <img
                :src="tweet.user.avatar"
                class="rounded-circle me-4"
                width="64"
                height="64"
            />
            <div class="tweet-body flex-grow-1">
                <div class="d-flex align-items-center mb-2">
                    <strong class="me-2 fs-5">{{ tweet.user.name }}</strong>
                    <small class="text-muted"
                        >@{{ tweet.user.handle }} · {{ tweet.time }}</small
                    >
                </div>
                <p class="fs-6 mb-3">{{ tweet.content }}</p>
                <div class="tweet-actions d-flex text-muted">
                    <button
                        class="btn btn-light btn-sm me-3"
                        @click="likeTweet(tweet.id)"
                    >
                        <i class="bi bi-heart me-1"></i> {{ tweet.likes }}
                    </button>
                    <button
                        class="btn btn-light btn-sm me-3"
                        @click="retweet(tweet.id)"
                    >
                        <i class="bi bi-arrow-repeat me-1"></i>
                        {{ tweet.retweets }}
                    </button>
                    <button
                        class="btn btn-light btn-sm"
                        @click="replyTo(tweet.id)"
                    >
                        <i class="bi bi-chat me-1"></i> Reply
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const tweets = ref([
    {
        id: 1,
        user: {
            name: "LeBron James",
            handle: "kingjames",
            avatar: "https://via.placeholder.com/64x64.png?text=LJ",
        },
        time: "2h",
        content: "Just dropped 30 tonight! 🔥",
        likes: 215,
        retweets: 72,
    },
    {
        id: 2,
        user: {
            name: "Tech Guru",
            handle: "techguru",
            avatar: "https://via.placeholder.com/64x64.png?text=TG",
        },
        time: "4h",
        content: "Vue 3 Composition API is 🔥",
        likes: 104,
        retweets: 31,
    },
]);

function likeTweet(id) {
    const tweet = tweets.value.find((t) => t.id === id);
    if (tweet) tweet.likes++;
}

function retweet(id) {
    const tweet = tweets.value.find((t) => t.id === id);
    if (tweet) tweet.retweets++;
}

function replyTo(id) {
    alert(`Reply to tweet ID: ${id}`);
}
</script>

<style scoped>
.feed-container {
    max-width: 700px;
}

.tweet:hover {
    background-color: #f1f3f5;
    cursor: pointer;
    border-radius: 8px;
}

.tweet-actions .btn {
    font-size: 0.95rem;
    padding: 4px 10px;
}
</style>
