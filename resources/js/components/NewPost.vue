<script setup>
import { useTextareaAutosize } from "@/composables/newPost/useTextareaAutosize";
import { usePostSubmit } from "@/composables/newPost/usePostSubmit";

const props = defineProps({
    profileImage: {
        type: String,
        default: "https://cdn-icons-png.flaticon.com/512/149/149071.png",
    },
});

const emit = defineEmits(["submit"]);

const {
    postContent,
    expanded,
    textarea,
    remainingChars,
    onFocus,
    onBlur,
    autoResize,
    clearContent,
} = useTextareaAutosize();

const { submitPost } = usePostSubmit(postContent, textarea, emit);

const clearPost = () => {
    clearContent();
};
</script>

<template>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex mb-2 position-relative">
                <!-- Profile Icon -->
                <img
                    :src="profileImage"
                    alt="Profile"
                    class="rounded me-3"
                    style="width: 48px; height: 48px; object-fit: cover"
                />

                <!-- Expanding Input -->
                <textarea
                    ref="textarea"
                    v-model="postContent"
                    class="form-control border-0 flex-grow-1 pe-5"
                    placeholder="What's happening?"
                    :rows="expanded ? 3 : 1"
                    @focus="onFocus"
                    @blur="onBlur"
                    @input="autoResize"
                    style="resize: none; overflow: hidden"
                ></textarea>

                <!-- Clear "X" inside textarea -->
                <button
                    v-if="postContent"
                    class="btn btn-icon-clear position-absolute top-0 end-0 mt-2 me-2"
                    @click="clearPost"
                    type="button"
                >
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            </div>

            <!-- Footer -->
            <!-- Footer -->
            <div
                v-if="expanded || postContent"
                class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2"
            >
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <small class="text-success"
                        >{{ remainingChars }} left</small
                    >
                    <button
                        class="btn btn-beet btn-sm d-flex align-items-center"
                        :disabled="!postContent.trim()"
                        @click="submitPost"
                    >
                        <i class="bi bi-send me-1"></i> Beet
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
textarea.form-control:focus {
    box-shadow: none;
}

/* Beet button */
.btn-beet {
    background-color: #43b881;
    border-color: #43b881;
    color: white;
}
.btn-beet:hover {
    background-color: #3ca573;
    border-color: #3ca573;
}
.btn-beet i {
    color: white;
}

/* Clear "x" button */
.btn-icon-clear {
    background: transparent;
    border: none;
    padding: 0;
    color: #dc3545;
    font-size: 1.1rem;
}
.btn-icon-clear:hover i {
    color: #a71d2a;
}

/* Placeholder styled like h3 and green */
textarea::placeholder {
    color: #43b881;
    font-size: 1.25rem;
    font-weight: 600;
    font-family: inherit;
}
</style>
