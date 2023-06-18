<template>
    <div>
        <div class="form-row p-6">
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
                <input v-model="tournament.description" type="text" class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <span>Дисциплина</span>
                <select v-model="tournament.discipline" class="form-control">
                    <option
                        v-for="disciplineOption in disciplineOptions"
                        :value="disciplineOption.slug"
                    >
                        {{ disciplineOption.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row p-6">
            <div class="form-group col-md-4">
                <span>Дата начала</span>
                <input v-model="tournament.start" type="date" class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <span>Дата окончания</span>
                <input v-model="tournament.end" type="date" class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <span>Количество команд</span>
                <input v-model="tournament.count_teams" type="number" class="form-control" />
            </div>
        </div>
        <div class="form-row p-6">
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
            tournament: {
                name: "",
                description: "",
                start: "",
                end: "",
                discipline: "",
                count_teams: 1,
            },
            disciplineOptions: [],
            publicOptions: [
                { slug: "open", name: "Открытый" },
                { slug: "closed", name: "Закрытый" },
            ],
            typeOptions: [
                { slug: "main", name: "Главный" },
                { slug: "qualifying", name: "Отборочный" },
            ],
        }
    },
    created() {
        this.getDisciplineOptions();
    },
    methods: {
        getDisciplineOptions() {
            axios.post('/api/tournament/get_discipline_options/')
                .then(({data}) => {
                    this.disciplineOptions = data.disciplineOptions
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                });
        }
    }
}
</script>

<style scoped>

</style>
