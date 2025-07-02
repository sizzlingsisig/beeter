import api from "@/axios"; // your axios instance

export default {
    async fetchMyProfile() {
        const res = await api.get("/users/me");
        return res.data.data;
    },

    async updateMyProfile(payload) {
        const res = await api.put("/users/me", payload);
        return res.data.data;
    },

    async register(payload) {
        const res = await api.post("/users", payload);
        return res.data.data;
    },
};
