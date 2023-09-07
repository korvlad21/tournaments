<template>
    <div class="bg-gray-100">
        <div class="container mx-auto my-5 p-5">
            <div class="md:flex no-wrap md:-mx-2">
                <!-- Iterate over teams -->
                <div v-for="team in teams" :key="team.id" class="w-full md:w-3/12 md:mx-2">
                    <!-- Profile Card -->
                    <div class="bg-white p-3 border-t-4 border-green-400">
                        <div class="image overflow-hidden">
                            <img class="h-auto w-full mx-auto" :src="team.path" alt="" />
                        </div>
                        <!-- Add a checkbox for each team -->
                        <input type="checkbox" v-model="selectedTeams" :value="team.id" />
                        <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">
                            {{ team.name }}
                        </h1>
                        <h3 class="text-gray-600 font-lg text-semibold leading-6">
                            {{ team.description }}
                        </h3>
                    </div>
                </div>
                <!-- Right Side -->
            </div>
            <!-- Add a button to submit selected teams -->
            <button @click="submitSelectedTeams" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Submit Selected Teams
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "TournamentAddTeams",
    props: {
        id: Number,
    },
    data() {
        return {
            teams: [],
            selectedTeams: [], // Array to store selected team IDs
        };
    },
    created() {
        this.getTeamsReadyInvitation()
    },
    methods: {
        getTeamsReadyInvitation() {
            axios
                .post("/api/tournament/get_teams_ready_invitation/", {
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
        submitSelectedTeams() {
            axios
                .post("/api/tournament/add_teams/", {
                    id: this.id,
                    teamsId: this.selectedTeams
                })
                .then(({ data }) => {
                    if(data.success){
                        this.teams = this.teams.filter((team) => !this.selectedTeams.includes(team.id));
                    }
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
