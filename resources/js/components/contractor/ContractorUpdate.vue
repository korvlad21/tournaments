<template>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>ИНН</span>
            <input
                v-model="contractor.INN"
                type="text"
                class="form-control"
            />
        </div>
        <div class="form-group col-md-4">
            <span>КПП</span>
            <input
                v-model="contractor.KPP"
                type="text"
                class="form-control"
            />
        </div>
        <div class="form-group col-md-4">
            <span>Название</span>
            <input v-model="contractor.name" type="text" class="form-control" />
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
                <span>Сфера деятельности</span>
                <input v-model="contractor.field_of_activity" type="text" class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <span>Описание</span>
                <input v-model="contractor.description" type="text" class="form-control" />
            </div>
        </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Контактная информация</span>
            <input v-model="contractor.contact" type="text" class="form-control" />
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <button v-if="undefined === this.id"
                type="submit"
                class="btn btn-primary btn15"
                @click="createContractor"
            >
                Создать контрагента
            </button>
            <button v-else
                    type="submit"
                    class="btn btn-primary btn15"
                    @click="updateContractor"
            >
                Обновить контрагента
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
const isOpen = ref(false);
const isSharedOpen = ref(false);

export default {
    name: "ContractorUpdate",
    props: {
        id: String,
    },
    data() {
        return {
            contractor: {
                INN: "",
                KPP: "",
                name: "",
                field_of_activity: "",
                description: "",
                contact: "",
            },
            logo: "",
            modal: {
                title: "",
                content: "",
                button: "Закрыть",
            },
        };
    },
    created() {
        this.getContractorInfo();
    },
    methods: {
        createContractor() {
            this.logo = this.$refs["file-upload"].files[0];
            let formData = new FormData();
            formData.append("INN", this.contractor.INN);
            formData.append("KPP", this.contractor.KPP);
            formData.append("name", this.contractor.name);
            formData.append("field_of_activity", this.contractor.field_of_activity);
            formData.append("description", this.contractor.description);
            formData.append("contact", this.contractor.contact);
            formData.append("logo", this.logo);
            axios
                .post("/api/contractor/create/", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Контрагент успешно создан успешно создана";
                    this.modal.content = "Контрагент успешно создан создана";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        updateContractor() {
            this.logo = this.$refs["file-upload"].files[0];
            let formData = new FormData();
            formData.append("INN", this.contractor.INN);
            formData.append("KPP", this.contractor.KPP);
            formData.append("name", this.contractor.name);
            formData.append("field_of_activity", this.contractor.field_of_activity);
            formData.append("description", this.contractor.description);
            formData.append("contact", this.contractor.contact);
            formData.append("logo", this.logo);
            axios
                .post("/api/contractor/update/" +this.id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Контрагент успешно обновлён";
                    this.modal.content = "Контрагент успешно обновлён";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getContractorInfo() {
            if (undefined === this.id) {
                return;
            }
            axios.post('/api/contractor/get_info/', {
                id: this.id
            })
                .then(({data}) => {
                    this.contractor.INN = data.INN;
                    this.contractor.KPP = data.KPP;
                    this.contractor.name = data.name;
                    this.contractor.field_of_activity = data.field_of_activity;
                    this.contractor.description = data.description;
                    this.contractor.contact = data.contact;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                });

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
