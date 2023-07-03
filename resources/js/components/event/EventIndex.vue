<template>
  <div v-for="event in events" class="bg-gray-100">
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
              <span
                  class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100"
              >
                            <img :src="event['path']" />
                  <!-- Если аватар есть прячем свг и показивыаем <img> -->
                            <svg
                                class="h-full w-full text-gray-300"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
                                />
                            </svg>
                        </span>
            <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">
                {{event['name']}}
            </h1>
            <h3 class="text-gray-600 font-lg text-semibold leading-6">
                {{event['description']}}
            </h3>
              <h3 class="text-gray-600 font-lg text-semibold leading-6">
                  Дата начала: {{event['start']}}
              </h3>
              <h3 class="text-gray-600 font-lg text-semibold leading-6">
                  Дата окончания: {{event['end']}}
              </h3>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefEventUpdate(event)"
              >
                  Редактировать
              </a>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefEventShow(event)"
              >
                  Смотреть
              </a>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefTournamentCreate(event)"
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
  name: "EventIndex",
  data() {
    return {
        events: [],
    }
  },
  created() {
    this.getAllEventInfo();
  },
  methods: {
      getAllEventInfo() {
          axios.post('/api/event/get_all_info/', {
              id: this.id
          })
              .then(({data}) => {
                  this.events = data
              })
              .catch((error) => {
                  console.error(error);
              })
              .finally(() => {
              });
    },
      getHrefEventUpdate(event) {
          return window.location.origin + '/event/edit/' + event['id'];
      },
      getHrefEventShow(event) {
          return window.location.origin + '/event/' + event['id'];
      },
      getHrefTournamentCreate(event) {
          return window.location.origin + '/tournament/create/' + event['id'];
      },
  }
};
</script>

<style scoped></style>
