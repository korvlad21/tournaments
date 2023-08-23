<template>
    <div class="bg-gray-100">
        <div class="container mx-auto my-5 p-5">
            <div class="md:flex no-wrap md:-mx-2">
                <!-- Left Side -->
                <div class="w-full md:w-8/12 md:mx-2">
                    <!-- Profile Card -->
                    <div class="bg-white p-3 border-t-4 border-green-400">
                        <div class="image overflow-hidden">
                            <img
                                class="h-auto w-full mx-auto"
                                src="https://lavinephotography.com.au/wp-content/uploads/2017/01/PROFILE-Photography-112.jpg"
                                alt=""
                            />
                        </div>
                        <h1
                            class="text-gray-900 font-bold text-xl leading-8 my-1"
                        >
                            {{ tournament.name }}
                        </h1>
                        <h3
                            class="text-gray-600 font-lg text-semibold leading-6"
                        >
                            {{ tournament.description }}
                        </h3>
                        <div v-for="team in teams" class="bg-gray-100">
                            {{team['number']}}.{{team['name']}}
                        </div>
                        <button
                            v-if="!existGroups"
                            @click="generateGroups()"
                            class="form-control max-w-[190px]"
                        >
                            Cгенерировать группы
                        </button>
                        <br>
                        <br>
                        <br>
                        <div v-for="group in groups" class="bg-green-100">
                            Группа №{{group['number']}}
                            <div v-for="team in group['teams']" class="bg-red-100">
                                {{team['number']}}.{{team['name']}}
                            </div>
                        </div>
                        <button
                            v-if="existGroups"
                            @click="generateCalendar()"
                            class="form-control max-w-[190px]"
                        >
                            Cгенерировать календарь
                        </button>
                    </div>
                </div>
                <!-- Right Side -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TournamentShow",
    props: {
        id: Number,
    },
    data() {
        return {
            tournament: {
                name: "",
                description: "",
            },
            teams:{},
            isOwn: false,
            groups: {},
        };
    },
    computed:{
        existGroups() {
            return Object.keys(this.groups).length !== 0;
        }
    },
    created() {
        this.getTournamentInfo();
        this.getOwn();
        this.getRoles();
        this.getTeams();
        this.getGroupsInfo();
    },
    methods: {
        getTournamentInfo() {
            axios
                .post("/api/tournament/get_info/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.tournament.name = data.name;
                    this.tournament.description = data.description;
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
        getTeams() {
            axios
                .post("/api/tournament/get_teams/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.teams = data.reduce((result, team) => {
                        result[team.id] = team;
                        return result;
                    }, {});
                    console.log(this.teams);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getGroupsInfo() {
            console.log(Object.keys(this.groups).length === 0)
            axios
                .post("/api/tournament/get_groups_info/", {
                    id: this.id,
                })
                .then(({ data }) => {
                    this.groups = data;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        generateGroups() {
            axios
                .post("/api/tournament/generate_groups/", {
                    id: this.id,
                    stage_id: 1,
                })
                .then(({ data }) => {
                    this.getGroupsInfo()
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        generateCalendar() {
            axios
                .post("/api/tournament/generate_calendar/", {
                    id: this.id,
                    stage_id: 1,
                })
                .then(({ data }) => {
                    // this.teams = data;
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
