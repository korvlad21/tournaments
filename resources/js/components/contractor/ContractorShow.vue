<template>
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
                    <img :src="path">
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
              <label
                  v-show="isOwn"
                  for="file-upload"
                  class="ml-5 rounded-md border border-gray-300 bg-white py-1.5 px-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50"
              >
              </label>
            <div class="form-row p-6">
                <div class="form-group col-md-4">
                    <span>ИНН</span>
                    {{contractor.INN}}
                </div>
                <div class="form-group col-md-4">
                    <span>КПП</span>
                    {{contractor.KPP}}
                </div>
                <div class="form-group col-md-4">
                    <span>Сфера деятельности</span>
                    {{contractor.field_of_activity}}
                </div>
            </div>
            <div class="form-row p-6">
              <div class="form-group col-md-4">
                  <span>Имя</span>
                  {{contractor.name}}
              </div>
              <div class="form-group col-md-4">
                  <span>Описание</span>
                  {{contractor.description}}
              </div>
              <div class="form-group col-md-4">
                  <span>Контактная информация</span>
                  {{contractor.contact}}
              </div>
          </div>
        </div>
        <!-- Right Side -->
</template>

<script>
export default {
  name: "ProfileShow",
  props: {
      id: Number,
  },
  data() {
    return {
        contractor: {
            INN: "",
            KPP: "",
            name: "",
            field_of_activity: "",
            description: "",
            contact: "",
        },
        logo: "",
        path: "",
        isOwn: false,
    }
  },
  created() {
    this.getContractorInfo();
    this.getOwn();
  },
  methods: {
     getContractorInfo() {
        axios.post('/api/contractor/get_info/', {
            id: this.id
        })
            .then(({data}) => {
                this.contractor.INN = data.INN;
                this.contractor.KPP = data.KPP;
                this.contractor.name = data.name;
                this.contractor.field_of_activity = data.field_of_activity;
                this.contractor.description = data.description;
                this.contractor.contact = data.contact;
                this.path= data.path;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
            });
    },
    getOwn() {
      axios.post('/api/contractor/is_own/', {
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
      handleFileUpload() {
          this.logo = this.$refs["file-upload"].files[0];
          let formData = new FormData();
          formData.append("logo", this.logo);
          formData.append("id", this.id);
          axios
              .post("/api/image/logo_team_upload/", formData, {
                  headers: {
                      "Content-Type": "multipart/form-data",
                  },
              })
              .then(({ data }) => {
                  this.path = data.path;
              })
              .catch((error) => {
                  console.error(error);
              })
              .finally(() => {});
      },
  }
};
</script>

<style scoped></style>
