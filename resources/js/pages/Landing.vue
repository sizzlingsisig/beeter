<template>
    <div class="themed-container">
        <div class="welcome-box">
            <img
                src="https://cdn-icons-png.flaticon.com/512/5281/5281053.png"
                alt="Logo"
                width="120"
                class="logo mb-3"
            />
            <h2 class="fw-bold text-center mb-2">Welcome to Beeter</h2>
            <p class="text-muted text-center mb-4">Get started below</p>

            <div class="d-flex flex-column gap-3 w-100">
                <button
                    class="btn btn-theme w-100"
                    @click="router.push('/login')"
                >
                    Login
                </button>
                <button
                    class="btn btn-outline-theme w-100"
                    @click="router.push('/signup')"
                >
                    Sign Up
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useRouter } from "vue-router";
const router = useRouter();
</script>
<style scoped>
.themed-container {
    min-height: 100vh;
    background-color: var(--color-bg);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
}

.welcome-box {
    border-radius: var(--radius);
    padding: 2rem;
    width: 100%;
    max-width: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.logo {
    display: block;
    margin: 0 auto;
}

.btn-theme {
    background-color: var(--color-primary);
    color: white;
    border-radius: var(--radius);
    border: none;
    font-weight: bold;
}

.btn-theme:hover {
    background-color: var(--color-primary-dark);
}

.btn-outline-theme {
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
    font-weight: bold;
    border-radius: var(--radius);
    background-color: transparent;
}

.btn-outline-theme:hover {
    background-color: var(--color-hover-bg);
}
</style>
