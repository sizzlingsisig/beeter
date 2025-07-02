import { defineStore } from "pinia";
import UserService from "@/services/UserService";

export const useUserStore = defineStore("user", {
    state: () => ({
        profile: null,
        loading: false,
        error: null,
        summary: null,
        summaryLoading: false,
        summaryError: null,
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
        async updateProfile({ nickname, bio }) {
            this.loading = true;
            this.error = null;
            try {
                // Only send nickname and bio in the update payload
                await UserService.updateMyProfile({ nickname, bio });
                // After updating, refresh summary to keep UI in sync
                await this.fetchSummary();
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
        async fetchSummary() {
            this.summaryLoading = true;
            this.summaryError = null;
            try {
                this.summary = await UserService.fetchSummary();
            } catch (err) {
                this.summaryError = err.response?.data?.message || err.message;
            } finally {
                this.summaryLoading = false;
            }
        },
    },
});
