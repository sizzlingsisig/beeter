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
                            :alt="`${nickname || 'Profile'} Image`"
                            class="img-fluid h-100 w-100"
                            style="object-fit: cover"
                        />
                    </div>
                </div>
                <div class="mt-5 pt-2 text-center">
                    <p class="text-muted small mb-0">POSTS</p>
                    <p class="fw-bold h6 mb-0" style="color: #42b983">
                        {{ posts ?? "—" }}
                    </p>
                </div>
            </div>

            <!-- Right -->
            <div
                class="flex-grow-1 mt-1 d-flex flex-column justify-content-baseline"
            >
                <h2
                    class="h4 fw-bold text-dark mb-0 text-truncate"
                    style="min-height: 1.5rem"
                >
                    {{ nickname || " " }}
                </h2>
                <p
                    class="text-muted mb-1 text-truncate"
                    style="min-height: 1.25rem"
                >
                    @{{ username || " " }}
                </p>
                <p class="text-muted small mb-0" style="min-height: 2rem">
                    {{ bio || " " }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    profileImage: String,
    nickname: String,
    username: String,
    posts: Number,
    bio: String,
});
</script>
