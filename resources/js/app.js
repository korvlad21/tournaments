
require('./bootstrap')
import { createApp } from 'vue'
import ExampleComponent from './components/ExampleComponent'
import TestComponent from './components/TestComponent'
import ProfileUpdate from "./components/profile/ProfileUpdate.vue";
import TeamUpdate from "./components/team/TeamUpdate.vue";
import TeamShow from "./components/team/TeamShow.vue";
import ProfileShow from "./components/profile/ProfileShow.vue";
import Profile from "./components/profile/ProfileTest.vue";
import ContractorUpdate from "./components/contractor/ContractorUpdate.vue";
import ContractorShow from "./components/contractor/ContractorShow.vue";
import EventUpdate from "./components/event/EventUpdate.vue";
import EventShow from "./components/event/EventShow.vue";
import TournamentUpdate from "./components/tournament/TournamentUpdate.vue";
import PlaceUpdate from "./components/place/PlaceUpdate.vue";
import PlaceShow from "./components/place/PlaceShow.vue";
import PlaceIndex from "./components/place/PlaceIndex.vue";
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
app.component('team-update', TeamUpdate)
app.component('team-show', TeamShow)
app.component('contractor-update', ContractorUpdate)
app.component('contractor-show', ContractorShow)
app.component('event-update', EventUpdate)
app.component('event-show', EventShow)
app.component('place-update', PlaceUpdate)
app.component('place-show', PlaceShow)
app.component('place-index', PlaceIndex)
app.component('tournament-update', TournamentUpdate)

app.use(vuetify).mount('#app')
