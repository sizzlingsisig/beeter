<template>
    <div
        class="bg-white rounded shadow overflow-hidden w-100 mb-3"
        style="max-width: 24rem"
    >
        <!-- Banner -->
        <div class="position-relative">
            <img
                src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80"
                alt="Cloud Banner"
                class="w-100"
                style="height: 8rem; object-fit: cover"
            />
        </div>

        <!-- Content -->
        <div
            class="d-flex position-relative px-3 pb-3"
            style="min-height: 7rem"
        >
            <!-- Left -->
            <div
                class="d-flex flex-column align-items-center"
                style="width: 6rem"
            >
                <div
                    class="position-absolute"
                    style="top: -2.5rem; left: 1.25rem"
                >
                    <div
                        class="rounded shadow border-white border-4 overflow-hidden"
                        style="width: 5rem; height: 5.5rem"
                    >
                        <img
                            :src="profileImage"
                            :alt="`${nickname} Image`"
                            class="img-fluid h-100 w-100"
                            style="object-fit: cover"
                        />
                    </div>
                </div>
                <div class="mt-5 pt-2 text-center">
                    <p class="text-muted small mb-0">POSTS</p>
                    <p class="fw-bold h6 mb-0" style="color: #42b983">
                        {{ postsCount }}
                    </p>
                </div>
            </div>

            <!-- Right -->
            <div
                class="flex-grow-1 mt-1 d-flex flex-column justify-content-baseline"
            >
                <template v-if="isEditing">
                    <input
                        v-model="editForm.nickname"
                        class="form-control mb-1"
                        :placeholder="nickname"
                        style="min-height: 1.5rem"
                    />
                    <input
                        v-model="editForm.username"
                        class="form-control mb-1"
                        :placeholder="username"
                        style="min-height: 1.25rem"
                        disabled
                    />
                    <textarea
                        v-model="editForm.bio"
                        class="form-control mb-1"
                        :placeholder="bio"
                        style="min-height: 2rem"
                    ></textarea>
                    <div class="d-flex gap-2 mt-2">
                        <button
                            class="btn btn-success btn-sm"
                            @click="saveEdit"
                            :disabled="userStore.loading"
                        >
                            Save
                        </button>
                        <button
                            class="btn btn-secondary btn-sm"
                            type="button"
                            @click="cancelEdit"
                            :disabled="userStore.loading"
                        >
                            Cancel
                        </button>
                    </div>
                    <div v-if="userStore.error" class="text-danger mt-2">
                        {{ userStore.error }}
                    </div>
                </template>
                <template v-else>
                    <h2
                        class="h4 fw-bold text-dark mb-0 text-truncate"
                        style="min-height: 1.5rem"
                    >
                        {{ nickname }}
                    </h2>
                    <p
                        class="text-muted mb-1 text-truncate"
                        style="min-height: 1.25rem"
                    >
                        @{{ username }}
                    </p>
                    <p class="text-muted small mb-0" style="min-height: 2rem">
                        {{ bio }}
                    </p>
                    <div v-if="userStore.summaryLoading" class="text-info mt-1">
                        Loading...
                    </div>
                    <div v-if="userStore.summaryError" class="text-danger mt-1">
                        {{ userStore.summaryError }}
                    </div>
                    <button
                        v-if="!userStore.summaryLoading"
                        class="btn btn-outline-secondary btn-sm mt-2"
                        @click="startEdit"
                    >
                        Edit
                    </button>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useUserStore } from "@/stores/userStore";
import { ref, computed, onMounted, watch } from "vue";

const userStore = useUserStore();
const defaultProfileImage =
    "https://pbs.twimg.com/profile_images/1382294345848483844/QuRwNZq1_400x400.jpg";

const isEditing = ref(false);
const editForm = ref({
    nickname: "",
    username: "",
    bio: "",
});

// When entering edit mode, copy the current summary fields to the form
function startEdit() {
    if (userStore.summary) {
        editForm.value.nickname = userStore.summary.nickname || "";
        editForm.value.username = userStore.summary.name || "";
        editForm.value.bio = userStore.summary.bio || "";
    }
    isEditing.value = true;
}

function cancelEdit() {
    isEditing.value = false;
    userStore.error = null;
    // Reset form fields to current summary
    if (userStore.summary) {
        editForm.value.nickname = userStore.summary.nickname || "";
        editForm.value.username = userStore.summary.name || "";
        editForm.value.bio = userStore.summary.bio || "";
    }
}

async function saveEdit() {
    await userStore.updateProfile({
        nickname: editForm.value.nickname,
        bio: editForm.value.bio,
    });
    isEditing.value = false;
    // No need to fetchSummary again here, updateProfile already does it in the store
}

// Populate editForm with summary when summary changes and NOT editing
watch(
    () => userStore.summary,
    (summary) => {
        if (summary && !isEditing.value) {
            editForm.value.nickname = summary.nickname || "";
            editForm.value.username = summary.name || "";
            editForm.value.bio = summary.bio || "";
        }
    },
    { immediate: true }
);

// Fetch user summary if not loaded
onMounted(async () => {
    if (!userStore.summary && !userStore.summaryLoading) {
        await userStore.fetchSummary();
    }
});

const nickname = computed(() => userStore.summary?.nickname || "User");
const username = computed(() => userStore.summary?.name || "user");
const bio = computed(() => userStore.summary?.bio || " ");
const postsCount = computed(() =>
    userStore.summary?.posts_count != null ? userStore.summary.posts_count : "—"
);
const profileImage = computed(
    () => userStore.summary?.profile_image || defaultProfileImage
);
</script>
