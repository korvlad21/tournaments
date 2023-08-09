<template>
    <transition name="modal-fade">
        <div v-if="isOpen" class="modal-overlay">
            <div class="modal-container">
                <div class="modal-content">
                    <slot></slot>
                </div>
                <button class="modal-close-button" @click="closeModal">
                    Закрыть
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        isOpen: Boolean,
    },
    methods: {
        closeModal() {
            this.$emit("update:isOpen", false);
        },
    },
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.modal-close-button {
    margin-top: 10px;
}
</style>
