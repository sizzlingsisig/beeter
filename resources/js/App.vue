<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import BlankLayout from "@/layouts/BlankLayout.vue";

const route = useRoute();
const layout = ref(DefaultLayout);

function updateLayout() {
    if (route.meta.layout === "blank") {
        layout.value = BlankLayout;
    } else {
        layout.value = DefaultLayout;
    }
}

updateLayout();
watch(() => route.meta.layout, updateLayout);
</script>

<template>
    <component :is="layout">
        <RouterView />
    </component>
</template>
