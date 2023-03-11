
require('./bootstrap')
import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import TestComponent from './components/TestComponent'
import Profile from "./components/profile/Profile.vue";
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
app.component('profile', Profile)

app.use(vuetify).mount('#app')
