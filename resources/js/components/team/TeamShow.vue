<template>
    <div class="bg-gray-100">
        <div class="container mx-auto my-5 p-5">
            <div class="md:flex no-wrap md:-mx-2">
                <!-- Left Side -->
                <div class="w-full md:w-3/12 md:mx-2">
                    <!-- Profile Card -->
                    <div class="bg-white p-3 border-t-4 border-green-400">
                        <div class="image overflow-hidden">
                            <img
                                class="h-auto w-full mx-auto"
                                src="https://lavinephotography.com.au/wp-content/uploads/2017/01/PROFILE-Photography-112.jpg"
                                alt=""
                            />
                        </div>
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
                            v-show="isOwn"
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
                        <h1
                            class="text-gray-900 font-bold text-xl leading-8 my-1"
                        >
                            {{ team.name }}
                        </h1>
                        <h3
                            class="text-gray-600 font-lg text-semibold leading-6"
                        >
                            {{ team.description }}
                        </h3>
                    </div>
                </div>
                <!-- Right Side -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TeamShow",
    props: {
        id: Number,
    },
    data() {
        return {
            team: {
                name: "",
                description: "",
            },
            logo: "",
            path: "",
            isOwn: false,
        };
    },
    created() {
        this.getTeamInfo();
        this.getOwn();
        this.getRoles();
    },
    methods: {
        getTeamInfo() {
            axios
                .post("/api/team/get_info/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.team.name = data.name;
                    this.team.description = data.description;
                    this.path = data.path;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getOwn() {
            axios
                .post("/api/team/is_own/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.isOwn = data.isOwn;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getRoles() {
            axios
                .post("/api/user/get_roles/")
                .then(({ data }) => {
                    this.roles = data.roles;
                    this.is_admin = this.roles.indexOf("admin") !== -1;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        handleFileUpload() {
            this.logo = this.$refs["file-upload"].files[0];
            let formData = new FormData();
            formData.append("logo", this.logo);
            formData.append("id", this.id);
            axios
                .post("/api/image/logo_team_upload/", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    this.path = data.path;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
    },
};
</script>

<style scoped></style>
