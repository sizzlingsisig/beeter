import { ref, computed, nextTick, watch } from "vue";

export function useTextareaAutosize(maxChars = 280) {
    const postContent = ref("");
    const expanded = ref(false);
    const textarea = ref(null);

    const remainingChars = computed(() => maxChars - postContent.value.length);

    const onFocus = () => {
        expanded.value = true;
    };

    const onBlur = () => {
        if (!postContent.value.trim()) {
            setTimeout(() => {
                if (!postContent.value.trim()) {
                    expanded.value = false;
                    nextTick(() => {
                        if (textarea.value)
                            textarea.value.style.height = "auto";
                    });
                }
            }, 100);
        }
    };

    const autoResize = () => {
        if (textarea.value) {
            textarea.value.style.height = "auto";
            textarea.value.style.height = textarea.value.scrollHeight + "px";
        }
    };

    const clearContent = () => {
        postContent.value = "";
        nextTick(() => {
            if (textarea.value) textarea.value.style.height = "auto";
        });
    };

    // Enforce character limit
    watch(postContent, (newVal) => {
        if (newVal.length > maxChars) {
            postContent.value = newVal.slice(0, maxChars);
        }
    });

    return {
        postContent,
        expanded,
        textarea,
        remainingChars,
        onFocus,
        onBlur,
        autoResize,
        clearContent,
    };
}
