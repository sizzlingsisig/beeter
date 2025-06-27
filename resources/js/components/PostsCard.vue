<template>
    <div class="card flex-grow-1" style="flex: 3; overflow-y: auto">
        <div class="card-body">
            <h5 class="card-title">Posts</h5>
            <ul class="list-unstyled">
                <li v-for="(post, index) in postList" :key="index" class="mb-2">
                    {{ post }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    postList: {
        type: Array,
        default: () => [],
    },
});
</script>
