

require('./bootstrap')
import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import TestComponent from './components/TestComponent'
import ProfileUpdate from "./components/profile/ProfileUpdate.vue";
import ProfileShow from "./components/profile/ProfileShow.vue";
import Profile from "./components/profile/ProfileTest.vue";
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})


const app = createApp({})

app.component('example-component', ExampleComponent)
app.component('test-component', TestComponent)
app.component('profile-show', ProfileShow)
app.component('profile-update', ProfileUpdate)
app.component('profile', Profile)

app.use(vuetify).mount('#app')
