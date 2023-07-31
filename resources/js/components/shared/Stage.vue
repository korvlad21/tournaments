<script setup>
const props = defineProps({
    stageCount: Number,
    discipline: String,
    stagesData: Object,
    stageName: Object,
    discipline: Array,
});
</script>

<template>
    <div class="p-6">
        <h2>Стадия: {{ stageCount }}</h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <span>Название стадии</span>
                <input
                    v-model="stagesData[stageName[stageCount]].name"
                    type="text"
                    class="form-control"
                />
            </div>
            <div class="form-group col-md-4">
                <span>Количество групп</span>
                <input
                    v-model="stagesData[stageName[stageCount]].groupCount"
                    type="number"
                    class="form-control"
                />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <span>Количество игр</span>
                <input
                    v-model="stagesData[stageName[stageCount]].gamesCount"
                    type="number"
                    class="form-control"
                />
            </div>
            <div class="form-group col-md-4">
                <span>Количество команд для перехода</span>
                <input
                    v-model="stagesData[stageName[stageCount]].teamsCount"
                    type="number"
                    class="form-control"
                />
            </div>
        </div>
        <div class="form-row p-6"></div>
    </div>
</template>
