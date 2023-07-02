<template>
  <div v-for="place in places" class="bg-gray-100">
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
                Название: {{place['name']}}
            </h1>
            <h3 class="text-gray-600 font-lg text-semibold leading-6">
                Описание {{place['description']}}
            </h3>
              <h4 class="text-gray-600 font-lg text-semibold leading-6">
                  Адрес: {{place['address']}}
              </h4>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefPlaceUpdate(place)"
              >
                  Редактировать
              </a>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefPlaceShow(place)"
              >
                  Смотреть
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
  name: "PlaceShow",
  props: {
      id: Number,
  },
  data() {
    return {
        places: [],
    }
  },
  created() {
    this.getAllPlaceInfo();
  },
  methods: {
      getAllPlaceInfo() {
          axios.post('/api/place/get_all_info/')
              .then(({data}) => {
                  this.places = data
              })
              .catch((error) => {
                  console.error(error);
              })
              .finally(() => {
              });

      },
      getHrefPlaceUpdate(place) {
          return window.location.origin + '/place/edit/' + place['id'];
      },
      getHrefPlaceShow(place) {
          return window.location.origin + '/place/' + place['id'];
      },
  }
};
</script>

<style scoped></style>
