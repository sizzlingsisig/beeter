<script setup>
import ProfileCard from "@/components/ProfileCard.vue";
import PostsCard from "@/components/PostsCard.vue";
import NewPost from "@/components/NewPost.vue";
import NewsFeed from "../components/NewsFeed.vue";
const userId = 1;
const nickname = "user";
const username = "username";
const posts = 50;
const bio = "this is a sample user bio ";
const profileImage = `https://randomuser.me/api/portraits/men/${userId}.jpg`;
const postList = [
    "Just dropped 30!",
    "Big win tonight 🔥",
    "Training hard for the playoffs!",
];
</script>

<template>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Left Column -->
            <div class="col-md-3 bg-light p-3 d-flex flex-column overflow-auto">
                <ProfileCard
                    :profileImage="profileImage"
                    :nickname="nickname"
                    :username="username"
                    :posts="posts"
                    :bio="bio"
                />
                <PostsCard :postList="postList" />
            </div>

            <!-- Middle Column -->
            <div class="col-md-6 p-3 overflow-auto border-start border-end">
                <NewPost :profileImage="profileImage" />
                <NewsFeed />
            </div>

            <!-- Right Column -->
            <div class="col-md-3 p-3 bg-white d-flex flex-column overflow-auto">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Trending</h5>
                        <ul class="list-unstyled mb-0">
                            <li>#Basketball</li>
                            <li>#ClutchTime</li>
                            <li>#MVP</li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Who to follow</h5>
                        <ul class="list-unstyled mb-0">
                            <li>@bron23</li>
                            <li>@kingjames</li>
                            <li>@ballislife</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.row {
    height: 100vh;
    overflow: hidden;
}

.col-md-3,
.col-md-6 {
    overflow-y: auto;
}
</style>
