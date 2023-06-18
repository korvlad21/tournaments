<template>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Название</span>
            <input
                v-model="place.name"
                type="text"
                class="form-control"
            />
        </div>
        <div class="form-group col-md-4">
            <span>Описание</span>
            <input v-model="place.description" type="text" class="form-control" />
        </div>
        <div class="form-group col-md-4">
            <span>Адрес</span>
            <input v-model="place.address" type="text" class="form-control" />
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <button v-if="undefined === this.id"
                    type="submit"
                    class="btn btn-primary btn15"
                    @click="createPlace"
            >
                Создать площадку
            </button>
            <button v-else
                    type="submit"
                    class="btn btn-primary btn15"
                    @click="updatePlace"
            >
                Изменить площадку
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
            place: {
                name: "",
                description: "",
                address: "",
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
        this.getPlaceInfo();
    },
    methods: {
        createPlace() {
            let formData = new FormData();
            formData.append("name", this.place.name);
            formData.append("description", this.place.description);
            formData.append("address", this.place.address);
            axios
                .post("/api/place/create/", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Площадка успешно создана";
                    this.modal.content = "Площадка успешно создана";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        updatePlace() {
            let formData = new FormData();
            formData.append("name", this.place.name);
            formData.append("description", this.place.description);
            formData.append("address", this.place.address);
            axios
                .post("/api/contractor/update/" +this.id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Площадка успешно обновлёна";
                    this.modal.content = "Площадка успешно обновлёна";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        deleteContractor() {
            axios
                .post("/api/place/delete/" +this.id, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.modal.title = "Площадка успешно удалена";
                    this.modal.content = "Площадка успешно удалена";
                    this.setSharedModalIsOpen(true);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getPlaceInfo() {
            if (undefined === this.id) {
                return;
            }
            axios.post('/api/place/get_info/', {
                id: this.id
            })
                .then(({data}) => {
                    this.place.name = data.name;
                    this.place.description = data.description;
                    this.place.address = data.address;
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
