<template>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Название</span>
            <input v-model="event.name" type="text" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <span>Описание</span>
            <input
                v-model="event.description"
                type="text"
                class="form-control"
            />
        </div>
        <div class="form-group col-md-4">
            <span>Дата начала</span>
            <input v-model="event.start" type="date" class="form-control" />
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <label class="block text-sm font-medium leading-6 text-gray-900"
                >Картинка логотип банер</label
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
        <div class="form-group col-md-4">
            <span>Дата окончания</span>
            <input v-model="event.end" type="date" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <span>Контрагент</span>
            <select v-model="event.contractor_id" class="form-control">
                <option
                    v-for="contractorOption in contractorOptions"
                    :value="contractorOption.id"
                >
                    {{ contractorOption.name }}
                </option>
            </select>
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <button
                v-if="undefined === this.id"
                type="submit"
                class="btn btn-primary btn15"
                @click="createEvent"
            >
                Создать эвент
            </button>
            <button
                v-else
                type="submit"
                class="btn btn-primary btn15"
                @click="updateEvent"
            >
                Обновить эвент
            </button>
        </div>
    </div>
    <ModalDialog
        :isOpen="isSharedOpen"
        :setModalIsOpen="setSharedModalIsOpen"
        :title="modal.title"
        :content="modal.content"
        :buttonText="modal.button"
    />
</template>

<script>
import { ref } from "vue";
import ModalDialog from "../shared/ModalDialog.vue";
import Modal from "../shared/ModalWithChild.vue";

const isOpen = ref(false);
const isSharedOpen = ref(false);

export default {
    name: "EventUpdate",
    props: {
        id: String,
    },
    data() {
        return {
            isModalOpen: false,
            event: {
                name: "",
                description: "",
                start: "",
                end: "",
                contractor_id: "",
            },
            contractorOptions: [],
            modal: {
                title: "",
                content: "",
                button: "Закрыть",
            },
        };
    },
    created() {
        this.getEventInfo();
        this.getContractorOptions();
    },
    methods: {
        createEvent() {
            this.logo = this.$refs["file-upload"].files[0];
            let formData = new FormData();
            formData.append("name", this.event.name);
            formData.append("description", this.event.description);
            formData.append("start", this.event.start);
            formData.append("end", this.event.end);
            formData.append("contractor_id", this.event.contractor_id);
            formData.append("logo", this.logo);
            axios
                .post("/api/event/create/", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Эвент успешно создан";
                    this.modal.content = "Эвент успешно создан";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        updateEvent() {
            this.logo = this.$refs["file-upload"].files[0];
            let formData = new FormData();
            formData.append("name", this.event.name);
            formData.append("description", this.event.description);
            formData.append("start", this.event.start);
            formData.append("end", this.event.end);
            formData.append("contractor_id", this.event.contractor_id);
            formData.append("logo", this.logo);
            axios
                .post("/api/event/update/" + this.id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Эвент успешно обновлён";
                    this.modal.content = "Эвент успешно обновлён";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getEventInfo() {
            if (undefined === this.id) {
                return;
            }
            axios
                .post("/api/event/get_info/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.event.name = data.name;
                    this.event.description = data.description;
                    this.event.start = data.start;
                    this.event.end = data.end;
                    this.event.contractor_id = data.contractor_id;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },

        getContractorOptions() {
            axios
                .post("/api/contractor/get_options/")
                .then(({ data }) => {
                    console.log(data.contractorOptions);
                    this.contractorOptions = data.contractorOptions;
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
