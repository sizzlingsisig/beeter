<script setup>
import { ref } from "vue";
import { useRouter, RouterLink } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

const email = ref("");
const password = ref("");
const router = useRouter();
const auth = useAuthStore();

const warning = ref(""); // For general errors (e.g. wrong credentials)
const fieldErrors = ref({}); // For Laravel validation errors (422)

const handleLogin = async () => {
    warning.value = "";
    fieldErrors.value = {};
    if (!email.value || !password.value) {
        warning.value = "Please fill in all fields.";
        return;
    }

    try {
        await auth.login({
            email: email.value,
            password: password.value,
        });
        router.push("/home");
    } catch (error) {
        // Laravel validation errors (422)
        if (error.errors) {
            fieldErrors.value = error.errors;
            warning.value = ""; // Don't show general error if field errors are present
        } else {
            warning.value = "Username or password is wrong. Please try again!";
        }
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
                        :class="{ 'is-invalid': fieldErrors.email }"
                        required
                    />
                    <div v-if="fieldErrors.email" class="invalid-feedback">
                        {{ fieldErrors.email.join(", ") }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        class="form-control"
                        v-model="password"
                        :class="{ 'is-invalid': fieldErrors.password }"
                        required
                    />
                    <div v-if="fieldErrors.password" class="invalid-feedback">
                        {{ fieldErrors.password.join(", ") }}
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <div v-if="warning" class="alert alert-warning mt-3">
                {{ warning }}
            </div>

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
