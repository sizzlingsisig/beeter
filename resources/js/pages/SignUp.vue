<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const auth = useAuthStore();

const data = ref({
    name: "",
    email: "",
    password: "",
    confirmPassword: "",
});

const loading = ref(false);

const handleSignup = async () => {
    if (loading.value) return;

    if (
        !data.value.name ||
        !data.value.email ||
        !data.value.password ||
        !data.value.confirmPassword
    ) {
        alert("Please fill in all fields.");
        return;
    }

    if (data.value.password !== data.value.confirmPassword) {
        alert("Passwords do not match.");
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

        alert("Account created successfully!");
        router.push("/home");
    } catch (error) {
        if (error.response?.data?.errors) {
            const messages = Object.values(error.response.data.errors).flat();
            alert(messages.join("\n"));
        } else {
            alert(error.response?.data?.message || "Signup failed");
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
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        v-model.trim="data.email"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        v-model.trim="data.password"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        v-model.trim="data.confirmPassword"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="btn btn-success w-100"
                    :disabled="loading"
                >
                    {{ loading ? "Creating..." : "Sign Up" }}
                </button>
            </form>

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
