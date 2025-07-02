<template>
    <div class="container py-4">
        <h1>User Store Test Page</h1>

        <div
            v-if="userStore.loading || userStore.summaryLoading"
            class="alert alert-info"
        >
            Loading...
        </div>
        <div v-if="userStore.error" class="alert alert-danger">
            {{ userStore.error }}
        </div>
        <div v-if="userStore.summaryError" class="alert alert-danger">
            {{ userStore.summaryError }}
        </div>

        <section class="mb-4">
            <h2>User Summary</h2>
            <button
                class="btn btn-sm btn-primary mb-2"
                @click="userStore.fetchSummary"
                :disabled="userStore.summaryLoading"
            >
                Refresh Summary
            </button>
            <table v-if="userStore.summary" class="table table-bordered w-auto">
                <tr>
                    <th>Name</th>
                    <td>{{ userStore.summary.name }}</td>
                </tr>
                <tr>
                    <th>Nickname</th>
                    <td>{{ userStore.summary.nickname }}</td>
                </tr>
                <tr>
                    <th>Bio</th>
                    <td>{{ userStore.summary.bio }}</td>
                </tr>
                <tr>
                    <th>Posts Count</th>
                    <td>{{ userStore.summary.posts_count }}</td>
                </tr>
            </table>
        </section>

        <section class="mb-4">
            <h2>Edit Nickname & Bio</h2>
            <form @submit.prevent="saveProfile" class="w-50">
                <div class="mb-2">
                    <label class="form-label">Nickname</label>
                    <input class="form-control" v-model="editForm.nickname" />
                </div>
                <div class="mb-2">
                    <label class="form-label">Bio</label>
                    <textarea
                        class="form-control"
                        v-model="editForm.bio"
                    ></textarea>
                </div>
                <button
                    class="btn btn-success me-2"
                    type="submit"
                    :disabled="userStore.loading"
                >
                    Save
                </button>
                <button
                    class="btn btn-secondary"
                    type="button"
                    @click="resetEdit"
                    :disabled="userStore.loading"
                >
                    Reset
                </button>
            </form>
        </section>

        <section>
            <h2>User Full Profile</h2>
            <button
                class="btn btn-sm btn-primary mb-2"
                @click="userStore.fetchProfile"
                :disabled="userStore.loading"
            >
                Refresh Profile
            </button>
            <pre v-if="userStore.profile" class="bg-light p-2 border">{{
                userStore.profile
            }}</pre>
        </section>
    </div>
</template>

<script setup>
import { useUserStore } from "@/stores/userStore";
import { ref, watchEffect } from "vue";

const userStore = useUserStore();

const editForm = ref({
    nickname: "",
    bio: "",
});

// Initialize editForm with summary when summary is loaded
watchEffect(() => {
    if (userStore.summary) {
        editForm.value.nickname = userStore.summary.nickname || "";
        editForm.value.bio = userStore.summary.bio || "";
    }
});

const saveProfile = async () => {
    await userStore.updateProfile({
        nickname: editForm.value.nickname,
        bio: editForm.value.bio,
    });
};

const resetEdit = () => {
    if (userStore.summary) {
        editForm.value.nickname = userStore.summary.nickname || "";
        editForm.value.bio = userStore.summary.bio || "";
    }
};
</script>

<style scoped>
.container {
    max-width: 650px;
}
pre {
    white-space: pre-wrap;
    word-break: break-all;
}
</style>
