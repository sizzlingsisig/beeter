<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const email = ref("");
const password = ref("");
const router = useRouter();
const auth = useAuthStore();
const handleLogin = async () => {
    if (!email.value || !password.value) {
        alert("Please fill in all fields.");
        return;
    }

    try {
        await auth.login({
            email: email.value,
            password: password.value,
        });

        router.push("/home"); // 👈 redirect to /home on success
    } catch (error) {
        alert(
            "Login failed: " + (error.response?.data?.message || error.message)
        );
    }
};
</script>

<template>
    <div
        class="d-flex justify-content-center align-items-center min-vh-100 bg-light"
    >
        <div class="card shadow-sm p-4 w-100" style="max-width: 400px">
            <h3 class="text-center mb-4">Login</h3>

            <form @submit.prevent="handleLogin">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        id="email"
                        type="email"
                        class="form-control"
                        v-model.trim="email"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        class="form-control"
                        v-model="password"
                        required
                    />
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                <span>Don't have an account?</span>
                <RouterLink to="/signup">Sign Up</RouterLink>
            </div>
        </div>
    </div>
</template>

<style scoped>
button {
    background: var(--color-primary);
    color: white;
    border: none;
}

button:hover {
    background: var(--color-primary-dark);
}
</style>
