<template>
    <div>
        <div v-if="stages.count === 0">
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
                        v-model="tournament.count_teams"
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
            </div>
        </div>
        <Stage
            v-if="stages.count > 0"
            :stageCount="stages.count"
            :stagesData="stagesData"
            :clearStageForm="clearStageForm"
            :discipline="tournament.discipline"
            :type-stage-options="typeStageOptions"
        />
        <div class="flex p-6 gap-2">
            <button
                v-if="stages.count < 3"
                @click="toggleStageCount(true)"
                class="form-control max-w-[137px]"
            >
                Далее
            </button>
            <button
                v-if="stages.count > 0"
                @click="toggleStageCount()"
                class="form-control max-w-[137px]"
            >
                Назад
            </button>
            <button
                v-if="stages.count > 0"
                @click="clearStageForm()"
                class="form-control max-w-[137px]"
            >
                Удалить
            </button>
            <button
                v-if="stages.count > 0"
                @click="logData(stagesData)"
                class="form-control max-w-[137px]"
            >
                Сохранить
            </button>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import Stage from "../shared/Stage.vue";

const stageCount = ref(0);

export default {
    name: "TournamentUpdate",
    props: {
        id: Number,
        event_id: Number,
    },
    data() {
        return {
            stagesData: {
                1: {},
                2: {},
                3: {},
            },
            // Кастыль
            tournament: {
                name: "",
                description: "",
                start: "",
                end: "",
                discipline: "",
                count_teams: 1,
                event_id: 0,
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
            stages: {
                count: stageCount,
            },
        };
    },
    created() {
        this.getDisciplineOptions();
        this.getEventOptions();
        this.getTypeStageOptions();
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
                    console.log(this.stagesData, this.stagesData[1])
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
        toggleStageCount(i) {
            i ? stageCount.value++ : stageCount.value--;
        },
        clearStageForm() {
            this.stagesData[this.stages.count] = {};
            this.stages.count > 1 && stageCount.value--;
        },
        logData(data) {
            console.log(data);
        },
    },
    components: { Stage },
};
</script>

<style scoped></style>
