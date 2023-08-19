<template>
    <div>
        <div v-if="currentStage === 0">
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <span>Эвент</span>
                    <select
                        v-model="tournament.event_id"
                        class="form-control"
                        required
                    >
                        <option
                            v-for="eventOption in eventOptions"
                            :value="eventOption.id"
                        >
                            {{ eventOption.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <span>Название</span>
                    <input
                        v-model="tournament.name"
                        type="text"
                        class="form-control"
                    />
                </div>
                <div class="form-group col-md-4">
                    <span>Описание</span>
                    <input
                        v-model="tournament.description"
                        type="text"
                        class="form-control"
                    />
                </div>
            </div>
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <span>Дата начала</span>
                    <input
                        v-model="tournament.start"
                        type="date"
                        class="form-control"
                    />
                </div>
                <div class="form-group col-md-4">
                    <span>Дата окончания</span>
                    <input
                        v-model="tournament.end"
                        type="date"
                        class="form-control"
                    />
                </div>
                <div class="form-group col-md-4">
                    <span>Количество команд</span>
                    <input
                        v-model="tournament.teamsCount"
                        type="number"
                        class="form-control"
                    />
                </div>
            </div>
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <span>Дисциплина</span>
                    <select
                        v-model="tournament.discipline"
                        class="form-control"
                        required
                    >
                        <option
                            v-for="disciplineOption in disciplineOptions"
                            :value="disciplineOption.slug"
                        >
                            {{ disciplineOption.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <span>Публичность</span>
                    <select v-model="tournament.public" class="form-control">
                        <option
                            v-for="publicOption in publicOptions"
                            :value="publicOption.slug"
                        >
                            {{ publicOption.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <span>Тип</span>
                    <select v-model="tournament.type" class="form-control">
                        <option
                            v-for="typeOption in typeOptions"
                            :value="typeOption.slug"
                        >
                            {{ typeOption.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <button @click="createStage(1)" class="form-control">
                        Создать стадию
                    </button>
                </div>
            </div>
        </div>
        <div v-else class="p-6">
            <h2 class="p-6">Стадия {{ currentStage }}</h2>
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <label>Название стадии:</label>
                    <input
                        v-model="currentStageData.name"
                        type="text"
                        class="form-control"
                    />
                </div>

                <div class="form-group col-md-4">
                    <label>Количество команд, идущих дальше:</label>
                    <input
                        v-model="currentStageData.teamsToNextStage"
                        type="number"
                        :max="currentStageData.teamsAllowed"
                        :min="1"
                        class="form-control"
                    />
                </div>
            </div>
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <button
                        @click="createNextStage"
                        :disabled="isNextStageDisabled"
                        class="form-control"
                    >
                        Создать следующую стадию
                    </button>
                </div>

                <div class="form-group col-md-4">
                    <button @click="deleteStage" class="form-control">
                        Удалить стадию
                    </button>
                </div>
            </div>
        </div>
        <div
            v-if="currentStageData.teamsToNextStage < 2 && currentStage != 0"
            class="p-6"
        >
            <h2 class="p-6">Последняя стадия</h2>
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <button @click="sendData" class="form-control">
                        Отправить данные
                    </button>
                </div>
            </div>
        </div>

        <div class="flex p-6 gap-2"></div>
    </div>
</template>

<script>
export default {
    name: "TournamentUpdate",
    props: {
        id: Number,
        event_id: Number,
    },
    data() {
        return {
            currentStage: 0,
            currentStageData: {
                name: "",
                teamsCount: 0,
                teamsToNextStage: 0,
                teamsAllowed: 0,
            },
            tournament: {
                name: "",
                description: "",
                start: "",
                end: "",
                discipline: "",
                teamsCount: 0,
                event_id: 0,
                stages: [],
            },
            disciplineOptions: [],
            eventOptions: [],
            publicOptions: [
                { slug: "open", name: "Открытый" },
                { slug: "closed", name: "Закрытый" },
            ],
            typeOptions: [
                { slug: "main", name: "Главный" },
                { slug: "qualifying", name: "Отборочный" },
            ],
            typeStageOptions: [],
        };
    },
    created() {
        this.getDisciplineOptions();
        this.getEventOptions();
        this.getTypeStageOptions();
    },
    computed: {
        isNextStageDisabled() {
            return (
                this.currentStageData.teamsToNextStage <= 1 ||
                this.currentStageData.teamsToNextStage ===
                    this.currentStageData.teamsCount
            );
        },
    },
    methods: {
        getDisciplineOptions() {
            axios
                .post("/api/tournament/get_discipline_options/")
                .then(({ data }) => {
                    this.disciplineOptions = data.disciplineOptions;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getEventOptions() {
            if (undefined !== this.event_id) {
                this.tournament.event_id = this.event_id;
            }
            axios
                .post("/api/event/get_event_options/")
                .then(({ data }) => {
                    this.eventOptions = data.eventOptions;
                    console.log(this.stagesData, this.stagesData[1]);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        getTypeStageOptions() {
            axios
                .post("/api/tournament/get_type_stage_options/")
                .then(({ data }) => {
                    this.typeStageOptions = data.typeStageOptions;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {});
        },
        createStage(stageNumber) {
            this.currentStage = stageNumber;
            this.currentStageData.name = `Стадия ${stageNumber}`;
            this.currentStageData.teamsCount = this.tournament.teamsCount;
            this.currentStageData.teamsAllowed === 0 &&
                (this.currentStageData.teamsAllowed =
                    this.tournament.teamsCount);
            this.currentStageData.teamsToNextStage === 0 &&
                (this.currentStageData.teamsToNextStage =
                    this.tournament.teamsCount);
        },
        createNextStage() {
            this.tournament.stages.push({ ...this.currentStageData });
            const nextStageNumber = this.currentStage + 1;
            this.currentStageData.teamsToNextStage =
                this.currentStageData.teamsToNextStage;
            this.currentStageData.teamsAllowed =
                this.currentStageData.teamsToNextStage;
            this.createStage(nextStageNumber);
        },
        deleteStage() {
            if (this.currentStage > 1) {
                this.tournament.stages.pop();
                this.currentStage -= 1;
                this.currentStageData =
                    this.tournament.stages[this.currentStage - 1];
            }
        },
        sendData() {
            !this.tournament.stages[this.currentStage - 1] &&
                this.tournament.stages.push({ ...this.currentStageData });

            console.log(this.tournament.stages);
        },
    },
};
</script>

<style scoped></style>
