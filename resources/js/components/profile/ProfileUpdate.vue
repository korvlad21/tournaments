<template>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Имя Пользователя</span>
            <input
                v-model="user.username"
                type="text"
                class="form-control"
            >
        </div>
        <div class="form-group col-md-4">
            <span>Имя</span>
            <input
                v-model="user.name"
                type="text"
                class="form-control"
            >
        </div>
        <div class="form-group col-md-4">
            <span>Email</span>
            <input
                v-model="user.email"
                type="text"
                class="form-control"
            >
        </div>
    </div>
    <div class="form-row p-6">
        <div class="form-group col-md-4">
            <span>Телефон</span>
            <input
                v-model="user.phone"
                type="text"
                class="form-control"
            >
        </div>
        <div class="form-group col-md-4">
            <span>Пол</span>
            <select
                v-model="user.sex"
                class="form-control"
            >
                <option v-for="sexOption in sexOptions" :value="sexOption.value">
                    {{ sexOption.text }}
                </option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <span>День рождения</span>
            <input
                v-model="user.birthday"
                type="date"
                class="form-control"
            >
        </div>
    </div>

</template>

<script>
export default {
    name: "ProfileUpdate",
    props: {
      slug: String,
    },
    data() {
        return {
            user: {
                username: '',
                name: '',
                email: '',
                phone: '',
                sex: '',
                birthday: '',
            },
            sexOptions: [
                { text: 'Муж', value: 'Муж' },
                { text: 'Жен', value: 'Жен' },
            ]
        }
    },
    created() {
        this.getUserInfo();
    },
    methods: {
        getUserInfo() {
            axios.post('/api/user/get_info/', {
                slug: this.slug
            })
                .then(({data}) => {
                    this.user.username = data.username;
                    this.user.name = data.name;
                    this.user.email = data.email;
                    this.user.phone = data.phone;
                    this.user.sex = data.sex;
                    this.user.birthday = data.birthday;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                });
        },
        getHrefEmail() {
            return "mailto:" + this.email;
        },
        getHrefUpdate() {
            return window.location.origin + '/profile/edit/' + this.slug;
        },
    }
};
</script>

<style scoped>

</style>
