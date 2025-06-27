<script setup>
/* ================================
   1. Imports
================================= */
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useRouter, RouterLink } from "vue-router";
import { useAuthStore } from "@/stores/auth";

/* ================================
   2. Router Setup
================================= */
const router = useRouter();

/* ================================
   3. Props
================================= */
const props = defineProps({
    brandIcon: {
        type: String,
        default: "https://cdn-icons-png.flaticon.com/512/5281/5281053.png",
    },
    profileImage: {
        type: String,
        default:
            "https://pbs.twimg.com/profile_images/1382294345848483844/QuRwNZq1_400x400.jpg",
    },
});

/* ================================
   4. Reactive State
================================= */
const isOpen = ref(false); // Profile dropdown
const showModal = ref(false); // Notification modal visibility
const selectedNotif = ref(null); // Selected notification data

const notifications = ref([
    { id: 1, title: "New follower", body: "LeBron James followed you." },
]);

/* ================================
   5. Dropdown Logic
================================= */
const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = (event) => {
    if (!event.target.closest(".profile-dropdown")) {
        isOpen.value = false;
    }
};

onMounted(() => window.addEventListener("click", closeDropdown));
onUnmounted(() => window.removeEventListener("click", closeDropdown));

/* ================================
   7. Modal / Notification Logic
================================= */
const openNotif = (notif) => {
    selectedNotif.value = notif;
    showModal.value = true;
    router.push("/notifications");
};

const closeModal = () => {
    showModal.value = false;
    selectedNotif.value = null;
    router.back();
};
const auth = useAuthStore();

const handleLogout = async () => {
    await auth.logout();
    router.push("/login"); // or use "/" for landing
};
</script>

<template>
    <nav class="navbar navbar-light custom-bg small-navbar sticky-top">
        <div
            class="container-fluid d-flex align-items-center justify-between custom-margin"
        >
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
                        :src="brandIcon"
                        alt="Brand"
                        class="ms-5"
                        style="width: 32px"
                    />
                </div>
            </RouterLink>

            <!-- Right Side -->
            <div class="me-lg-5 d-flex align-items-center gap-3 gap-lg-4">
                <!-- Search -->
                <form class="me-3" role="search">
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
                            :src="profileImage"
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
                            <button class="dropdown-item" @click="handleLogout">
                                Log Out
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Beet Button -->
                <button class="btn btn-beet ms-3">
                    <i class="bi bi-lightning-charge me-1"></i> Beet
                </button>
            </div>
        </div>
    </nav>
    <hr />
    <!-- Notification Modal -->
    <div
        v-if="showModal"
        class="modal fade show"
        tabindex="-1"
        style="display: block; background-color: rgba(0, 0, 0, 0.5)"
        @click.self="closeModal"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ selectedNotif?.title }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>{{ selectedNotif?.body }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="closeModal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Navbar Styling */
.small-navbar {
    font-size: var(--font-size-small);
    padding-top: var(--navbar-padding-y);
    padding-bottom: var(--navbar-padding-y);
}

/* Background */
.custom-bg {
    background-color: var(--color-bg);
}

/* Margin Control */
.custom-margin {
    margin-inline: var(--container-margin-x);
}
@media (min-width: 992px) {
    .custom-margin {
        margin-inline: var(--container-margin-lg);
    }
}

/* Nav Links */
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

/* Search */
.input-group .form-control {
    border: 1px solid var(--color-primary);
}
.input-group .form-control:focus {
    border-color: var(--color-primary-dark);
}
.input-group .bi-search {
    color: var(--color-primary-dark);
}

/* Dropdown Menu */
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

/* Profile */
.profile-img {
    width: var(--profile-img-size);
    height: var(--profile-img-size);
    object-fit: cover;
}

/* Beet Button */
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

/* Remove HR Margin */
hr {
    margin: 0;
}
</style>
