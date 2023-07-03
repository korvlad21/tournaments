<template>
    <div v-for="team in teams" class="bg-gray-100">
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
                            <img :src="team['path']" />
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
                            {{ team['name'] }}
                        </h1>
                        <h3
                            class="text-gray-600 font-lg text-semibold leading-6"
                        >
                            {{ team['description'] }}
                        </h3>
                    </div>
                </div>
                <div class="w-full md:w-3/12 md:mx-2">
                    <!-- Profile Card -->
                    <a
                        class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                        :href="this.getHrefTeamUpdate(team)"
                    >
                        Редактировать
                    </a>
                    <a
                        class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                        :href="this.getHrefTeamShow(team)"
                    >
                        Смотреть
                    </a>
                </div>
                <!-- Right Side -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TeamIndex",
    data() {
        return {
            teams: []
        };
    },
    created() {
        this.getAllTeamInfo()
    },
    methods: {
        getAllTeamInfo() {
            axios
                .post("/api/team/get_all_info/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.teams = data
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getHrefTeamUpdate(team) {
            return window.location.origin + '/team/edit/' + team['id'];
        },
        getHrefTeamShow(team) {
            return window.location.origin + '/team/' + team['id'];
        },
    },
};
</script>

<style scoped></style>
