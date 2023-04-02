<template>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Название</span>
            <input
                v-model="team.name"
                type="text"
                class="form-control"
            />
        </div>
        <div class="form-group col-md-4">
            <span>Описание</span>
            <input v-model="team.description" type="text" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <label class="block text-sm font-medium leading-6 text-gray-900"
            >Лого</label
            >
            <div class="mt-2 flex items-center">
                <span
                    class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100"
                >
                    <img :src="path" />
                    <!-- Если аватар есть прячем свг и показивыаем <img> -->
                    <svg
                        class="h-full w-full text-gray-300"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
                        />
                    </svg>
                </span>
                <label
                    for="file-upload"
                    class="ml-5 rounded-md border border-gray-300 bg-white py-1.5 px-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50"
                >
                    <span>Выбрать изображение</span>
                    <input
                        id="file-upload"
                        name="file-upload"
                        ref="file-upload"
                        type="file"
                        class="sr-only"
                    />
                </label>
            </div>
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <button
                type="submit"
                class="btn btn-primary btn15"
                @click="createTeam"
            >
                Создать команду
            </button>
        </div>
    </div>
    <!-- модалка паспорта -->
    <ProfileModal :isOpen="isOpen" :setModalIsOpen="setModalIsOpen" />
</template>

<script>

import { ref } from "vue";
const isOpen = ref(false);
const isSharedOpen = ref(false);

export default {
    name: "TeamUpdate",
    props: {
        slug: String,
    },
    data() {
        return {
            team: {
                name: "",
                description: "",
            },
            logo: "",
        };
    },
    methods: {
        createTeam() {
            this.logo = this.$refs["file-upload"].files[0];
            let formData = new FormData();
            formData.append("name", this.team.name);
            formData.append("description", this.team.description);
            formData.append("logo", this.logo);
            axios
                .post("/api/team/create/", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Команда успешно создана";
                    this.modal.content = "Команда успешно создана";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        setModalIsOpen(value) {
            isOpen.value = value;
        },
        setSharedModalIsOpen(value) {
            isSharedOpen.value = value;
        },
    },
};
</script>

<script setup>
const verified = ref(false);

function handleVerifiedClick() {
    verified.value = !verified.value;
}
</script>
