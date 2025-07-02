<!-- src/components/NotificationModal.vue -->
<template>
    <div
        class="modal fade show"
        tabindex="-1"
        style="display: block; background-color: rgba(0, 0, 0, 0.5)"
        @click.self="$emit('close')"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ notif?.title }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="$emit('close')"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>{{ notif?.body }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="$emit('close')">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    notif: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>
.modal {
    z-index: 1050;
}
</style>
