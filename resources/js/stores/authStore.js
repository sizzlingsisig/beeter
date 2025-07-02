import { defineStore } from "pinia";
import authService from "@/services/authService";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
        userName: (state) => state.user?.name ?? "",
    },
    actions: {
        async register(payload) {
            await authService.register(payload);
            this.user = authService.user;
            this.token = authService.token;
        },
        async login(payload) {
            await authService.login(payload);
            this.user = authService.user;
            this.token = authService.token;
        },
        async fetchUser() {
            await authService.fetchUser();
            this.user = authService.user;
        },
        async logout() {
            await authService.logout();
            this.user = null;
            this.token = null;
        },
        init() {
            authService.init();
            this.user = authService.user;
            this.token = authService.token;
        },
    },
});
