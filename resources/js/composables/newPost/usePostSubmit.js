// composables/usePostSubmit.js
// Submit behavior

// Emitting data

// Resetting UI

import { nextTick } from "vue";

export function usePostSubmit(postContentRef, textareaRef, emit) {
    const submitPost = () => {
        const content = postContentRef.value.trim();
        if (content) {
            emit("submit", content);
            postContentRef.value = "";
            nextTick(() => {
                if (textareaRef.value) textareaRef.value.style.height = "auto";
            });
        }
    };

    return {
        submitPost,
    };
}
