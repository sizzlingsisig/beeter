import api from "@/axios"; // your axios instance

export default {
    async fetchMyProfile() {
        const res = await api.get("/user-info");
        return res.data.data;
    },

    async updateMyProfile(payload) {
        // FIX: endpoint should be /user-info (not /users-info)
        const res = await api.put("/user-info", payload);
        return res.data.data;
    },

    async register(payload) {
        const res = await api.post("/user-info", payload);
        return res.data.data;
    },

    async fetchSummary() {
        const res = await api.get("/user-info/summary");
        return res.data; // <- use .data only if backend responds directly with the summary object
    },
};
