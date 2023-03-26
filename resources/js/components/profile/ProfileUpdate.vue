<template>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Имя Пользователя</span>
            <input
                v-model="user.username"
                type="text"
                class="form-control"
                readonly="readonly"
            />
        </div>
        <div class="form-group col-md-4">
            <span>Имя</span>
            <input v-model="user.name" type="text" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <span>Email</span>
            <input v-model="user.email" type="text" class="form-control" />
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Телефон</span>
            <input v-model="user.phone" type="text" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <span>Статус</span>
            <input v-model="user.status" type="text" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <span>Описание о себе</span>
            <input
                v-model="user.description"
                type="textarea"
                class="form-control"
            />
        </div>
        <div class="form-group col-md-4">
            <span>Пол</span>
            <select v-model="user.sex" class="form-control">
                <option
                    v-for="sexOption in sexOptions"
                    :value="sexOption.value"
                >
                    {{ sexOption.text }}
                </option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <span>День рождения</span>
            <input v-model="user.birthday" type="date" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <label class="block text-sm font-medium leading-6 text-gray-900"
                >Аватар</label
            >
            <div class="mt-2 flex items-center">
                <span
                    class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100"
                >
                    <img :src="user.path" />
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
                        v-on:change="handleFileUpload()"
                        id="file-upload"
                        name="file-upload"
                        ref="file-upload"
                        type="file"
                        class="sr-only"
                    />
                </label>
            </div>
        </div>
        <div class="flex gap-2">
            <button
                type="submit"
                class="btn btn-primary btn15"
                @click="updateData"
            >
                Обновить данные
            </button>
            <button
                class="btn"
                :class="[verified ? 'bg-green-500' : 'bg-red-500']"
                @click="handleVerifiedClick()"
            >
                {{ !verified ? "Подтвердить данные" : "Данные подтверждены" }}
            </button>
            <button
                type="button"
                @click="setModalIsOpen(true)"
                class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            >
                открыть модалку паспорта
            </button>

            <button
                type="button"
                @click="setSharedModalIsOpen(true)"
                class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            >
                открыть переносимую модалку
            </button>
        </div>
    </div>
    <!-- модалка паспорта -->
    <ProfileModal :isOpen="isOpen" :setModalIsOpen="setModalIsOpen" />
    <!-- переносимая модалка -->
    <ModalDialog
        :isOpen="isSharedOpen"
        :setModalIsOpen="setSharedModalIsOpen"
        :title="modal.title"
        :content="modal.content"
        :buttonText="modal.button"
    />
</template>

<script setup>
import ProfileModal from "./ProfileModal";
import ModalDialog from "../shared/ModalDialog.vue";

import { ref, onMounted, reactive } from "vue";

const props = defineProps({
    slug: String,
});

onMounted(() => {
    getUserInfo();
});

const user = reactive({
    username: "",
    name: "",
    email: "",
    phone: "",
    status: "",
    sex: "",
    birthday: "",
    description: "",

    // для кнопки подтверждения учетки
    verified: false,

    avatar: "",
    path: "",
});

const sexOptions = [
    { text: "Муж", value: "Муж" },
    { text: "Жен", value: "Жен" },
];

const modal = reactive({
    title: "модал",
    content: "ваы",
    button: "Закрыть",
});

const rules = [
    (value) => {
        return (
            !value ||
            !value.length ||
            value[0].size < 2000000 ||
            "Avatar size should be less than 2 MB!"
        );
    },
];

function getUserInfo() {
    axios
        .post("/api/user/get_info/", {
            slug: props.slug,
        })
        .then(({ data }) => {
            user.username = data.username;
            user.name = data.name;
            user.email = data.email;
            user.phone = data.phone;
            user.status = data.status;
            user.sex = data.sex;
            user.birthday = data.birthday;
            user.description = data.description;
            user.path = data.path;
        })
        .catch((error) => {
            console.error(error);
        })
        .finally(() => {});
}

function getHrefEmail() {
    // не понял откуда берется имэил
    return "mailto:" + user.email;
}

function getHrefUpdate() {
    return window.location.origin + "/profile/edit/" + props.slug;
}

function updateData() {
    // проверка при нажати на конопку - удалить

    axios
        .post("/profile/update/", {
            slug: props.slug,
            user: user,
        })
        .then(({ data }) => {
            modal.title = "Данные обновлены";
            modal.content = "Данные успешно обновлены";
            setSharedModalIsOpen(true);
        })
        .catch((error) => {
            console.error(error);
        })
        .finally(() => {});
}

function handleFileUpload() {
    user.avatar = ref(["file-upload"]).value;
    let formData = new FormData();
    formData.append("avatar", user.avatar);
    formData.append("slug", props.slug);
    axios
        .post("/api/image/avatar_upload/", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(({ data }) => {
            user.path = data.path;
        })
        .catch((error) => {
            console.error(error);
        })
        .finally(() => {});
}
// для модалки паспорта
const isOpen = ref(false);

function setModalIsOpen(value) {
    isOpen.value = value;
}
// для общей модалки
const isSharedOpen = ref(false);

function setSharedModalIsOpen(value) {
    isSharedOpen.value = value;
}
// для демонстрации кнопки - удалить
const verified = ref(false);

// для демонстрации кнопки - удалить
function handleVerifiedClick() {
    verified.value = !verified.value;
}
</script>

<style scoped></style>
