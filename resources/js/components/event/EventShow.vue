<template>
  <div class="bg-gray-100">
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
            <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">
                {{event.name}}
            </h1>
            <h3 class="text-gray-600 font-lg text-semibold leading-6">
                {{event.description}}
            </h3>
              <h3 class="text-gray-600 font-lg text-semibold leading-6">
                  Дата начала: {{event.start}}
              </h3>
              <h3 class="text-gray-600 font-lg text-semibold leading-6">
                  Дата окончания: {{event.end}}
              </h3>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefTournamentCreate()"
              >
                  Создать турнир
              </a>
          </div>
        </div>
        <!-- Right Side -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EventShow",
  props: {
      id: Number,
  },
  data() {
    return {
        event: {
            name: "",
            description: "",
            start: "",
            end: "",
        },
        isOwn: false
    }
  },
  created() {
    this.getEventInfo();
    this.getOwn();
    this.getRoles();
  },
  methods: {
      getEventInfo() {
          console.log(this.id)
          axios.post('/api/event/get_info/', {
              id: this.id
          })
              .then(({data}) => {
                  this.event.name = data.name;
                  this.event.description = data.description;
                  this.event.start = data.start;
                  this.event.end = data.end;
                  this.event.contractor_id = data.contractor_id;
              })
              .catch((error) => {
                  console.error(error);
              })
              .finally(() => {
              });
    },
    getOwn() {
      axios.post('/api/event/is_own/', {
          id: this.id
      })
          .then(({data}) => {
              this.isOwn = data.isOwn;
          })
          .catch((error) => {
              console.error(error);
          })
          .finally(() => {

          });
      },
    getRoles() {
       axios.post('/api/user/get_roles/')
       .then(({data}) => {
         this.roles = data.roles
         this.is_admin = this.roles.indexOf('admin') !== -1
       })
       .catch((error) => {
         console.error(error);
       })
       .finally(() => {
       });
      },
      getHrefTournamentCreate() {
          return window.location.origin + '/tournament/create/' + this.id;
      },
  }
};
</script>

<style scoped></style>
