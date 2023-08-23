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
                        <h1
                            class="text-gray-900 font-bold text-xl leading-8 my-1"
                        >
                            {{ user.name }}
                        </h1>
                        <h3
                            class="text-gray-600 font-lg text-semibold leading-6"
                        >
                            {{ user.status }}
                        </h3>
                        <p
                            class="text-sm text-gray-500 hover:text-gray-600 leading-6"
                        >
                            {{ user.description }}
                        </p>
                        <ul
                            class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm"
                        >
                            <li class="flex items-center py-3">
                                <span>Статус</span>
                                <span class="ml-auto">
                                    <span
                                        v-if="user.is_online"
                                        class="bg-green-500 py-1 px-2 rounded text-white text-sm"
                                    >
                                        В сети
                                    </span>
                                    <span
                                        v-else
                                        class="bg-red-500 py-1 px-2 rounded text-white text-sm"
                                    >
                                        Не в сети
                                    </span>
                                </span>
                            </li>
                            <li class="flex items-center py-3">
                                <span>Зарегистрирован</span>
                                <span class="ml-auto">{{
                                    user.created_at
                                }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- End of profile card -->
                    <div class="my-4"></div>
                    <!-- Friends card -->
                    <div class="bg-white p-3 hover:shadow">
                        <div
                            class="flex items-center space-x-3 font-semibold text-gray-900 text-xl leading-8"
                        >
                            <span class="text-green-500">
                                <svg
                                    class="h-5 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                            </span>
                            <span>Друзья</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <div
                                v-for="friendUser in friends"
                                class="text-center my-2"
                            >
                                <img
                                    class="h-16 w-16 rounded-full mx-auto"
                                    :src="friendUser.path"
                                    alt=""
                                />
                                <a
                                    :href="this.getHrefFriend(friendUser.slug)"
                                    class="text-main-color"
                                    >{{ friendUser.name }}</a
                                >
                            </div>
                        </div>
                    </div>
                    <!-- End of friends card -->
                </div>
                <!-- Right Side -->
                <div class="w-full md:w-9/12 mx-2 h-64">
                    <!-- Profile tab -->
                    <!-- Info Section -->
                    <div class="bg-white p-3 shadow-sm rounded-sm">
                        <div
                            class="flex items-center space-x-2 font-semibold text-gray-900 leading-8"
                        >
                            <span clas="text-green-500">
                                <svg
                                    class="h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </span>
                            <span class="tracking-wide">Информация</span>
                        </div>
                        <div class="text-gray-700">
                            <div class="grid md:grid-cols-2 text-sm">
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Имя
                                    </div>
                                    <div class="px-4 py-2">
                                        {{ this.user.name }}
                                    </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Имя Пользователя
                                    </div>
                                    <div class="px-4 py-2">
                                        {{ this.user.username }}
                                    </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Пол
                                    </div>
                                    <div class="px-4 py-2">
                                        {{ this.user.sex }}
                                    </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Телефон
                                    </div>
                                    <div class="px-4 py-2">
                                        {{ this.user.phone }}
                                    </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Вид спорта
                                    </div>
                                    <div class="px-4 py-2">Футбол</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Команда
                                    </div>
                                    <div class="px-4 py-2">ТОПКА РУ</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        Email.
                                    </div>
                                    <div class="px-4 py-2">
                                        <a
                                            class="text-blue-800"
                                            :href="this.getHrefEmail()"
                                            >{{ this.user.email }}</a
                                        >
                                    </div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">
                                        День рождения
                                    </div>
                                    <div class="px-4 py-2">
                                        {{ this.user.birthday }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-show="!isAuthUser">
                            <button
                                v-if="friend.subscriber"
                                class="btn"
                                :class="[
                                    friend.subscription
                                        ? 'bg-green-500'
                                        : 'bg-red-500',
                                ]"
                                @click="handleSubscribeClick()"
                            >
                                {{
                                    !friend.subscription
                                        ? "Подписан на вас"
                                        : "В друзьях"
                                }}
                            </button>
                            <button
                                v-else
                                class="btn"
                                :class="[
                                    friend.subscription
                                        ? 'bg-green-500'
                                        : 'bg-red-500',
                                ]"
                                @click="handleSubscribeClick()"
                            >
                                {{
                                    !friend.subscription
                                        ? "Добавить в друзья"
                                        : "Вы подписаны"
                                }}
                            </button>
                            <button
                                class="btn bg-red-500"
                                @click="setModalIsOpen(true)"
                            >
                                Добавить в команду
                            </button>
                        </div>

                        <button
                            class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                        >
                            Подробная информация
                        </button>
                        <a
                            v-show="isAuthUser"
                            class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                            :href="this.getHrefUpdate()"
                        >
                            Редактировать
                        </a>
                    </div>
                    <!-- End of info section -->

                    <div class="my-4"></div>

                    <!-- rs and Achivs -->
                    <div class="bg-white p-3 shadow-sm rounded-sm">
                        <div class="grid grid-cols-2">
                            <div>
                                <div
                                    class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3"
                                >
                                    <span clas="text-green-500">
                                        <svg
                                            class="h-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                    </span>
                                    <span class="tracking-wide">Турниры</span>
                                </div>
                                <ul class="list-inside space-y-2">
                                    <li>
                                        <div class="text-teal-600">КС ГО.</div>
                                        <div class="text-gray-500 text-xs">
                                            Март 2022
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-teal-600">
                                            Шахматы.
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            Март 2022
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-teal-600">Литрбол</div>
                                        <div class="text-gray-500 text-xs">
                                            Март 2022
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-teal-600">
                                            Гонки на санках.
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            Март 2022
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <div
                                    class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3"
                                >
                                    <span clas="text-green-500">
                                        <svg
                                            class="h-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                fill="#fff"
                                                d="M12 14l9-5-9-5-9 5 9 5z"
                                            />
                                            <path
                                                fill="#fff"
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"
                                            />
                                        </svg>
                                    </span>
                                    <span class="tracking-wide"
                                        >Достижения</span
                                    >
                                </div>
                                <ul class="list-inside space-y-2">
                                    <li>
                                        <div class="text-teal-600">
                                            Великий метатель лепешек
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            Апрель 1
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-teal-600">
                                            Литрболист года
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            Апрель 1
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of  grid -->
                    </div>
                    <!-- End of profile -->
                    <button @click="openModal" class="btn btn-blue">
                        открыть модалку
                    </button>
                </div>
            </div>
            <ModalWithChild
                :isOpen="isModalOpen"
                @update:isOpen="isModalOpen = $event"
            >
                <span>Выбрать команду(-ы) в которую пригласить</span>

                <label v-for="team in teams" :key="team.id">
                    <input
                        type="checkbox"
                        v-model="invitedTeams"
                        :value="team.id"
                    />
                    {{ team.name }}
                </label>
            </ModalWithChild>
        </div>
    </div>
</template>

<script>
import ModalWithChild from "../shared/ModalWithChild.vue";

import { ref } from "vue";
const isOpen = ref(false);

export default {
    name: "ProfileShow",
    props: {
        slug: String,
    },
    data() {
        return {
            teams: [],
            invitedTeams: [],
            user: {
                username: "",
                name: "",
                email: "",
                phone: "",
                status: "",
                sex: "",
                birthday: "",
                description: "",
                created_at: "",
                is_online: false,
            },
            friend: {
                subscriber: false,
                subscription: false,
            },
            friends: {},
            roles: "",
            is_admin: false,
            path: "",
            isAuthUser: false,
            isModalOpen: false,
        };
    },
    created() {
        this.getUserInfo();
        this.getAuthUser();
        this.getRoles();
        this.getFriends();
        this.getAllTeamInfo();
    },
    methods: {
        getUserInfo() {
            axios
                .post("/api/user/get_info/", {
                    slug: this.slug,
                })
                .then(({ data }) => {
                    this.user.username = data.username;
                    this.user.name = data.name;
                    this.user.email = data.email;
                    this.user.status = data.status;
                    this.user.phone = data.phone;
                    this.user.sex = data.sex;
                    this.user.birthday = data.birthday;
                    this.user.description = data.description;
                    this.user.created_at = data.created_at;
                    this.user.is_online = data.is_online;
                    this.path = data.path;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getAuthUser() {
            axios
                .post("/api/user/is_auth_user/", {
                    slug: this.slug,
                })
                .then(({ data }) => {
                    this.isAuthUser = data.isAuthUser;
                    if (false === this.isAuthUser) {
                        this.isFriend();
                    }
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getHrefEmail() {
            return "mailto:" + this.email;
        },
        getHrefUpdate() {
            return window.location.origin + "/profile/edit/" + this.slug;
        },
        getHrefFriend(slug) {
            console.log(slug);
            console.log(this.friends);
            return window.location.origin + "/profile/" + slug;
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
        getFriends() {
            axios
                .post("/api/user/get_friends/", {
                    slug: this.slug,
                })
                .then(({ data }) => {
                    this.friends = data.friends;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        isFriend() {
            axios
                .post("/api/user/is_friend/", {
                    slug: this.slug,
                })
                .then(({ data }) => {
                    this.friend.subscriber = data.subscriber;
                    this.friend.subscription = data.subscription;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        handleSubscribeClick() {
            axios
                .post("/api/user/is_subscribe/", {
                    slug: this.slug,
                })
                .then(({ data }) => {
                    this.friend.subscription = data.subscription;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        // setModalIsOpen(value) {
        //     isOpen.value = value;
        // },
        openModal() {
            this.isModalOpen = true;
        },
        async getAllTeamInfo() {
            await axios
                .post("/api/team/get_all_info/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.teams = data;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
    },
    components: { ModalWithChild },
};
</script>

<style scoped>
.btn {
    @apply font-bold py-2 px-4 rounded;
}
.btn-blue {
    @apply bg-blue-500 text-white;
}
.btn-blue:hover {
    @apply bg-blue-700;
}
</style>
