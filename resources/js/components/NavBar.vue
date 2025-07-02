<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter, RouterLink } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

const router = useRouter();
const auth = useAuthStore();

const isOpen = ref(false); // Profile dropdown
const showNotifModal = ref(false); // Notification modal
const showBeetModal = ref(false); // Beet post modal
const showLogoutModal = ref(false); // Logout confirmation modal
const selectedNotif = ref(null);

const notifications = ref([
    { id: 1, title: "New follower", body: "LeBron James followed you." },
]);

// Beet Post State
const beetContent = ref("");
const beetLoading = ref(false);
const beetError = ref("");

// Dropdown
const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};
const closeDropdown = (event) => {
    if (!event.target.closest(".profile-dropdown")) isOpen.value = false;
};
onMounted(() => window.addEventListener("click", closeDropdown));
onUnmounted(() => window.removeEventListener("click", closeDropdown));

// Notification Modal Logic
const openNotif = (notif) => {
    selectedNotif.value = notif;
    showNotifModal.value = true;
    router.push("/notifications");
};
const closeNotifModal = () => {
    showNotifModal.value = false;
    selectedNotif.value = null;
    router.back();
};

// Beet Modal Logic
const openBeetModal = () => {
    beetContent.value = "";
    beetError.value = "";
    showBeetModal.value = true;
};
const closeBeetModal = () => {
    beetContent.value = "";
    beetError.value = "";
    showBeetModal.value = false;
};
const submitBeet = async () => {
    beetError.value = "";
    if (!beetContent.value.trim()) {
        beetError.value = "Post content cannot be empty.";
        return;
    }
    beetLoading.value = true;
    try {
        // Replace this with your API call or Pinia action to create a post
        // Example: await postsStore.createPost({ content: beetContent.value });
        // Here, we just simulate success:
        await new Promise((res) => setTimeout(res, 700));
        closeBeetModal();
        // Optionally route to feed or refresh posts
        // router.push("/home");
    } catch (e) {
        beetError.value = "Could not create post. Please try again.";
    } finally {
        beetLoading.value = false;
    }
};

// Logout Modal Logic
const openLogoutModal = () => {
    isOpen.value = false;
    showLogoutModal.value = true;
};
const closeLogoutModal = () => {
    showLogoutModal.value = false;
};
const confirmLogout = async () => {
    showLogoutModal.value = false;
    await auth.logout();
    router.push("/login");
};
</script>

<template>
    <nav class="navbar navbar-light custom-bg small-navbar sticky-top">
        <div class="container-fluid d-flex align-items-center custom-margin">
            <!-- Left Nav -->
            <div class="ms-lg-5 d-flex align-items-center">
                <ul
                    class="navbar-nav d-flex flex-row align-items-center gap-4 gap-lg-5 small mb-0"
                >
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link active d-flex align-items-center gap-1"
                            to="/home"
                        >
                            <i class="bi bi-house-door"></i> Home
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn nav-link d-flex align-items-center gap-1 p-0 mt-2 bg-transparent border-0"
                            style="text-align: left"
                            @click="openNotif(notifications[0])"
                        >
                            <i class="bi bi-bell"></i> Notification
                        </button>
                    </li>
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link d-flex align-items-center gap-1"
                            to="/me"
                        >
                            <i class="bi bi-person-circle"></i> Me
                        </RouterLink>
                    </li>
                </ul>
            </div>

            <!-- Brand -->
            <RouterLink
                class="navbar-brand mx-auto d-none d-lg-block"
                to="/home"
            >
                <div class="ms-5">
                    <img
                        src="https://cdn-icons-png.flaticon.com/512/5281/5281053.png"
                        alt="Brand"
                        class="ms-5"
                        style="width: 32px"
                    />
                </div>
            </RouterLink>

            <!-- Right Side -->
            <div class="me-lg-5 d-flex align-items-center gap-2 gap-lg-2">
                <!-- Search -->
                <form
                    class="me-3 d-flex align-items-center"
                    role="search"
                    @submit.prevent
                >
                    <div class="input-group position-relative">
                        <input
                            type="search"
                            class="form-control rounded-pill ps-3 pe-5"
                            placeholder="Search"
                        />
                        <span
                            class="position-absolute end-0 top-50 translate-middle-y pe-3 text-secondary"
                        >
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </form>

                <!-- Profile Dropdown -->
                <div class="dropdown profile-dropdown" @click.stop>
                    <button
                        class="btn p-0 border-0 bg-transparent"
                        @click="toggleDropdown"
                    >
                        <img
                            :src="
                                auth.user?.profileImage ||
                                'https://pbs.twimg.com/profile_images/1382294345848483844/QuRwNZq1_400x400.jpg'
                            "
                            alt="Profile"
                            class="rounded border profile-img"
                        />
                    </button>
                    <ul
                        class="dropdown-menu dropdown-menu-end mt-2 slim-dropdown"
                        :class="{ show: isOpen }"
                    >
                        <li>
                            <RouterLink class="dropdown-item" to="/me"
                                >Profile</RouterLink
                            >
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <button
                                class="dropdown-item"
                                @click="openLogoutModal"
                            >
                                Log Out
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Beet Button -->
                <button class="btn btn-beet ms-3" @click="openBeetModal">
                    <i class="bi bi-lightning-charge me-1"></i> Beet
                </button>
            </div>
        </div>
    </nav>
    <hr />

    <!-- Notification Modal -->
    <div
        v-if="showNotifModal"
        class="modal fade show"
        tabindex="-1"
        style="display: block; background-color: rgba(0, 0, 0, 0.5)"
        @click.self="closeNotifModal"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ selectedNotif?.title }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeNotifModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>{{ selectedNotif?.body }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="closeNotifModal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Beet Modal -->
    <div
        v-if="showBeetModal"
        class="modal fade show"
        tabindex="-1"
        style="display: block; background-color: rgba(0, 0, 0, 0.5)"
        @click.self="closeBeetModal"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form @submit.prevent="submitBeet">
                    <div class="modal-header">
                        <h5 class="modal-title">Create a New Post</h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeBeetModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <textarea
                            class="form-control"
                            rows="4"
                            v-model.trim="beetContent"
                            placeholder="What's on your mind?"
                            :disabled="beetLoading"
                            required
                        ></textarea>
                        <div v-if="beetError" class="text-danger mt-2">
                            {{ beetError }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="closeBeetModal"
                            :disabled="beetLoading"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="beetLoading"
                        >
                            {{ beetLoading ? "Posting..." : "Post" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div
        v-if="showLogoutModal"
        class="modal fade show"
        tabindex="-1"
        style="display: block; background-color: rgba(0, 0, 0, 0.5)"
        @click.self="closeLogoutModal"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log Out</h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeLogoutModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="closeLogoutModal">
                        Cancel
                    </button>
                    <button class="btn btn-danger" @click="confirmLogout">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.small-navbar {
    font-size: var(--font-size-small);
    padding-top: var(--navbar-padding-y);
    padding-bottom: var(--navbar-padding-y);
}
.custom-bg {
    background-color: var(--color-bg);
}
.custom-margin {
    margin-inline: var(--container-margin-x);
}
@media (min-width: 992px) {
    .custom-margin {
        margin-inline: var(--container-margin-lg);
    }
}
.navbar-nav .nav-link {
    color: var(--color-text);
}
.navbar-nav .nav-link:hover,
.navbar-nav .router-link-active {
    color: var(--color-primary);
}
.navbar-nav .nav-link {
    position: relative;
    padding-bottom: 2px;
    transition: color 0.3s;
}
.navbar-nav .router-link-active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    width: 100%;
    background-color: var(--color-primary);
    border-radius: 1px;
    transition: width 0.3s ease;
}
.dropdown-menu {
    background-color: var(--color-bg);
    color: var(--color-text);
    border: 1px solid #ddd;
}
.dropdown-menu .dropdown-item {
    color: var(--color-text);
}
.dropdown-menu .dropdown-item:hover {
    background-color: var(--color-hover-bg);
    color: var(--color-primary);
}
.dropdown-divider {
    border-color: var(--color-divider);
}
.slim-dropdown {
    min-width: var(--dropdown-width);
    font-size: var(--font-size-small);
}
.profile-img {
    width: var(--profile-img-size);
    height: var(--profile-img-size);
    object-fit: cover;
}
.btn-beet {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
    font-size: var(--font-size-small);
}
.btn-beet:hover {
    background-color: var(--color-primary-dark);
    border-color: var(--color-primary-dark);
}
hr {
    margin: 0;
}
</style>
