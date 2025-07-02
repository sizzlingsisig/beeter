import axiosClient from "@/axios";

class AuthService {
    constructor() {
        this.token = localStorage.getItem("token") || null;
        this.user = null;

        if (this.token) {
            axiosClient.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;
        }
    }

    async register(payload) {
        try {
            const response = await axiosClient.post("/register", payload);
            this.token = response.data.token;
            localStorage.setItem("token", this.token);
            axiosClient.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;
            await this.fetchUser();
        } catch (error) {
            if (error.response && error.response.status === 422) {
                throw error.response.data;
            }
            throw error;
        }
    }

    async login(payload) {
        try {
            const response = await axiosClient.post("/login", payload);
            this.token = response.data.token;
            localStorage.setItem("token", this.token);
            axiosClient.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;
            await this.fetchUser();
        } catch (error) {
            this.token = null;
            localStorage.removeItem("token");
            if (
                error.response &&
                (error.response.status === 422 || error.response.status === 401)
            ) {
                throw error.response.data;
            }
            throw error;
        }
    }

    async fetchUser() {
        try {
            const response = await axiosClient.get("/user");
            this.user = response.data;
            return this.user;
        } catch (error) {
            this.user = null;
            if (error.response && error.response.status === 401) {
                this.token = null;
                localStorage.removeItem("token");
                delete axiosClient.defaults.headers.common["Authorization"];
            }
            throw error;
        }
    }

    async logout() {
        try {
            await axiosClient.post("/logout");
        } catch (e) {
            // Ignore errors on logout
        }
        this.user = null;
        this.token = null;
        localStorage.removeItem("token");
        delete axiosClient.defaults.headers.common["Authorization"];
    }

    init() {
        const token = localStorage.getItem("token");
        if (token) {
            this.token = token;
            axiosClient.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${token}`;
            this.fetchUser();
        }
    }
}

export default new AuthService();
