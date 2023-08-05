<script setup>
const props = defineProps({
    stageCount: Number,
    discipline: String,
    stagesData: Object,
    discipline: Array,
    typeStageOptions: Array,
});
</script>

<template>
    <div class="p-6">
        <h2>Стадия: {{ stageCount }}</h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <span>Название стадии</span>
                <input
                    v-model="stagesData[stageCount].name"
                    type="text"
                    class="form-control"
                />
            </div>
            <div class="form-group col-md-4">
                <span>Количество групп</span>
                <input
                    v-model="stagesData[stageCount].groupCount"
                    type="number"
                    class="form-control"
                />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <span>Количество игр</span>
                <input
                    v-model="stagesData[stageCount].gamesCount"
                    type="number"
                    class="form-control"
                />
            </div>
            <div class="form-group col-md-4">
                <span>Количество команд для перехода</span>
                <input
                    v-model="stagesData[stageCount].teamsCount"
                    type="number"
                    class="form-control"
                />
            </div>
            <div class="form-group col-md-4">
                <span>Тип</span>
                <select v-model="stagesData[stageCount].type" class="form-control">
                    <option
                        v-for="typeStageOption in typeStageOptions"
                        :value="typeStageOption.slug"
                    >
                        {{ typeStageOption.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row p-6"></div>
    </div>
</template>
