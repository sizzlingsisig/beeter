<template>
    <div class="modal-backdrop" @click.self="$emit('close')">
        <div class="modal-content">
            <h5 class="mb-2">🔥 Beet Mode Activated!</h5>
            <p>You're now in Beet mode. Go wild!</p>
            <button class="btn btn-danger mt-3" @click="$emit('close')">
                Close
            </button>
        </div>
    </div>
</template>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 0.5rem;
    width: 300px;
    text-align: center;
}
</style>
