import { defineStore } from "pinia";
import axiosClient from "@/axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null,
    }),

    actions: {
        async register(payload) {
            const response = await axiosClient.post("/register", payload);
            this.token = response.data.token;
            localStorage.setItem("token", this.token);
            axiosClient.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;

            await this.fetchUser();
        },

        async login(payload) {
            try {
                const response = await axiosClient.post("/login", payload);

                this.token = response.data.token;
                localStorage.setItem("token", this.token);

                // Set token on axios headers for future requests
                axiosClient.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;

                await this.fetchUser();
            } catch (error) {
                // Optional: clear token on error, rethrow for UI to catch
                this.token = null;
                localStorage.removeItem("token");
                throw error;
            }
        },
        async fetchUser() {
            try {
                const response = await axiosClient.get("/user");
                this.user = response.data;
            } catch (error) {
                this.user = null;
            }
        },

        async logout() {
            await axiosClient.post("/logout");
            this.user = null;
            this.token = null;
            localStorage.removeItem("token");
        },
        init() {
            const token = localStorage.getItem("token");

            if (token) {
                this.token = token;
                axiosClient.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${token}`;
                this.fetchUser(); // Optional: fetch user info on app load
            }
        },
    },
});
