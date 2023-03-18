<template>
ntcn
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
