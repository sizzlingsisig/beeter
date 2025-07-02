<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

const router = useRouter();
const auth = useAuthStore();

const data = ref({
    name: "",
    email: "",
    password: "",
    confirmPassword: "",
});

const loading = ref(false);

// For field-specific errors (Laravel 422) and general warning
const fieldErrors = ref({});
const warning = ref("");

const handleSignup = async () => {
    fieldErrors.value = {};
    warning.value = "";

    if (loading.value) return;

    if (
        !data.value.name ||
        !data.value.email ||
        !data.value.password ||
        !data.value.confirmPassword
    ) {
        warning.value = "Please fill in all fields.";
        return;
    }

    if (data.value.password !== data.value.confirmPassword) {
        warning.value = "Passwords do not match.";
        return;
    }

    loading.value = true;

    try {
        await auth.register({
            name: data.value.name,
            email: data.value.email,
            password: data.value.password,
            password_confirmation: data.value.confirmPassword,
        });

        router.push("/home");
    } catch (error) {
        if (error.errors) {
            fieldErrors.value = error.errors;
            warning.value = ""; // Don't show general error if field errors are present
        } else if (error.response?.data?.errors) {
            fieldErrors.value = error.response.data.errors;
            warning.value = "";
        } else if (error.message) {
            warning.value = error.message;
        } else {
            warning.value = "Signup failed. Please try again.";
        }
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div
        class="container d-flex align-items-center justify-content-center min-vh-100 bg-light"
    >
        <div class="card shadow-sm p-4 w-100" style="max-width: 400px">
            <h3 class="text-center mb-4">Create Account</h3>

            <form @submit.prevent="handleSignup">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model.trim="data.name"
                        :class="{ 'is-invalid': fieldErrors.name }"
                        required
                    />
                    <div v-if="fieldErrors.name" class="invalid-feedback">
                        {{ fieldErrors.name.join(", ") }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        v-model.trim="data.email"
                        :class="{ 'is-invalid': fieldErrors.email }"
                        required
                    />
                    <div v-if="fieldErrors.email" class="invalid-feedback">
                        {{ fieldErrors.email.join(", ") }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        v-model.trim="data.password"
                        :class="{ 'is-invalid': fieldErrors.password }"
                        required
                    />
                    <div v-if="fieldErrors.password" class="invalid-feedback">
                        {{ fieldErrors.password.join(", ") }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        v-model.trim="data.confirmPassword"
                        :class="{
                            'is-invalid': fieldErrors.password_confirmation,
                        }"
                        required
                    />
                    <div
                        v-if="fieldErrors.password_confirmation"
                        class="invalid-feedback"
                    >
                        {{ fieldErrors.password_confirmation.join(", ") }}
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn btn-success w-100"
                    :disabled="loading"
                >
                    {{ loading ? "Creating..." : "Sign Up" }}
                </button>
            </form>

            <div v-if="warning" class="alert alert-warning mt-3">
                {{ warning }}
            </div>

            <div class="text-center mt-3">
                <span>Already have an account?</span>
                <a href="#" @click.prevent="router.push('/login')">Login</a>
            </div>
        </div>
    </div>
</template>

<style scoped>
button {
    background: var(--color-primary);
    color: white;
    border: none;
    transition: 0.3s;
}

button:hover {
    background: var(--color-primary-dark);
}

button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
