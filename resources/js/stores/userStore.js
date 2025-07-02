import { defineStore } from "pinia";
import UserService from "@/services/UserService";

export const useUserStore = defineStore("user", {
    state: () => ({
        profile: null,
        loading: false,
        error: null,
    }),
    actions: {
        async fetchProfile() {
            this.loading = true;
            this.error = null;
            try {
                this.profile = await UserService.fetchMyProfile();
            } catch (err) {
                this.error = err.response?.data?.message || err.message;
            } finally {
                this.loading = false;
            }
        },
        async updateProfile(data) {
            this.loading = true;
            this.error = null;
            try {
                this.profile = await UserService.updateMyProfile(data);
            } catch (err) {
                this.error = err.response?.data?.message || err.message;
            } finally {
                this.loading = false;
            }
        },
        async register(data) {
            this.loading = true;
            this.error = null;
            try {
                this.profile = await UserService.register(data);
            } catch (err) {
                this.error = err.response?.data?.message || err.message;
            } finally {
                this.loading = false;
            }
        },
    },
});
