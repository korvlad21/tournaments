<template>
          <!-- Profile Card -->
          <div v-for="contractor in contractors" class="bg-white p-3 border-t-4 border-green-400">
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
                    <img :src="contractor['path']">
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
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <span>ИНН</span>
                    {{contractor['INN']}}
                </div>
                <div class="form-group col-md-4">
                    <span>КПП</span>
                    {{contractor['KPP']}}
                </div>
                <div class="form-group col-md-4">
                    <span>Сфера деятельности</span>
                    {{contractor['field_of_activity']}}
                </div>
            </div>
            <div class="form-row p-6">
              <div class="form-group col-md-4">
                  <span>Имя</span>
                  {{contractor['name']}}
              </div>
              <div class="form-group col-md-4">
                  <span>Описание</span>
                  {{contractor['description']}}
              </div>
              <div class="form-group col-md-4">
                  <span>Контактная информация</span>
                  {{contractor['contact']}}
              </div>
          </div>
              <div class="form-row p-6">
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefContractorUpdate(contractor)"
              >
                  Редактировать
              </a>
              <a
                  class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                  :href="this.getHrefContractorShow(contractor)"
              >
                  Смотреть
              </a>
              </div>
        </div>
        <!-- Right Side -->
</template>

<script>
export default {
  name: "ContractorIndex",
  data() {
    return {
        contractors: []
    }
  },
  created() {
    this.getAllContractorInfo();
  },
  methods: {
     getAllContractorInfo() {
        axios.post('/api/contractor/get_all_info/')
            .then(({data}) => {
                this.contractors = data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
            });
    },
    getHrefContractorUpdate(contractor) {
        return window.location.origin + '/contractor/edit/' + contractor['id'];
    },
    getHrefContractorShow(contractor) {
        return window.location.origin + '/contractor/' + contractor['id'];
    },
  }
};
</script>

<style scoped></style>
