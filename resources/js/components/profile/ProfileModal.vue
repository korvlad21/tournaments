<script setup>
import { reactive } from "vue";

import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";

const props = defineProps({
    isOpen: Boolean,
    setModalIsOpen: Function,
});

const formData = reactive({
    user: {
        name: "",
        serial: "",
        sex: "",
        birthday: "",
        scan: {},
    },
    sexOptions: [
        { text: "Муж", value: "Муж" },
        { text: "Жен", value: "Жен" },
    ],
    rules: [
        (value) => {
            return (
                !value ||
                !value.length ||
                value[0].size < 2000000 ||
                "Avatar size should be less than 2 MB!"
            );
        },
    ],
});

const onSubmit = async () => {
    try {
        await axios
            .post("/api/user/.../", {
                slug: this.slug,
            })
            .then(() => {});
    } catch (err) {
        console.log(err);
    }
};
</script>

<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog
            as="div"
            :open="isOpen"
            @close="setModalIsOpen(false)"
            class="relative z-10"
        >
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black opacity-90" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all sm:ml-64"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Папспортные Данные
                            </DialogTitle>
                            <form class="mt-2">
                                <label
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Сфотографирйтесь с паспортом, так, чтобы было чётко видно ваше лицо, фото вашего паспорта и серия и номер паспорта</label
                                >
                                <div
                                    class="mt-2 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
                                >
                                    <div class="space-y-1 text-center">
                                        <svg
                                            class="mx-auto h-12 w-12 text-gray-400"
                                            stroke="currentColor"
                                            fill="none"
                                            viewBox="0 0 48 48"
                                            aria-hidden="true"
                                        >
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label
                                                for="passport-upload"
                                                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
                                            >
                                                <span>Загрузите </span>
                                                <input
                                                    v-on:change ="handlePassportUpload()"
                                                    id="passport-upload"
                                                    name="passport-upload"
                                                    ref="passport-upload"
                                                    type="file"
                                                    class="sr-only"
                                                />
                                            </label>
                                            <p class="pl-1">
                                                или перетащите фаил
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF до 10MB
                                        </p>
                                    </div>
                                </div>
                                <span>Серия и номер паспорта</span>
                                <input v-model="passport" type="text" class="form-control" />
                            </form>

                            <div class="mt-4">
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @submit.prevent="onSubmit()"
                                    @click="sendPassport()"
                                >
                                    Отправить
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script>


export default {
    name: "ProfileUpdate",
    data() {
        return {
            image: '',
            passport: '',
        }
    },
    methods: {
        sendPassport() {
            this.image = this.$refs["passport-upload"].files[0];
            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('passport', this.passport);
            axios.post("/api/image/passport_upload/", formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                })
                .then(({ data }) => {
                    this.setModalIsOpen(false)
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
    }
}
</script>
