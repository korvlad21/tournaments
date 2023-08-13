require("./bootstrap");
import { createApp } from "vue";
import ExampleComponent from "./components/ExampleComponent";
import TestComponent from "./components/TestComponent";
import ProfileUpdate from "./components/profile/ProfileUpdate.vue";
import TeamUpdate from "./components/team/TeamUpdate.vue";
import TeamShow from "./components/team/TeamShow.vue";
import TeamIndex from "./components/team/TeamIndex.vue";
import ProfileShow from "./components/profile/ProfileShow.vue";
import Profile from "./components/profile/ProfileTest.vue";
import ContractorUpdate from "./components/contractor/ContractorUpdate.vue";
import ContractorShow from "./components/contractor/ContractorShow.vue";
import ContractorIndex from "./components/contractor/ContractorIndex.vue";
import EventUpdate from "./components/event/EventUpdate.vue";
import EventShow from "./components/event/EventShow.vue";
import EventIndex from "./components/event/EventIndex.vue";
import TournamentUpdate from "./components/tournament/TournamentUpdate.vue";
import TournamentIndex from "./components/tournament/TournamentIndex.vue";
import TournamentShow from "./components/tournament/TournamentShow.vue";
import PlaceUpdate from "./components/place/PlaceUpdate.vue";
import PlaceShow from "./components/place/PlaceShow.vue";
import PlaceIndex from "./components/place/PlaceIndex.vue";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { plugin, defaultConfig } from "@formkit/vue";

const vuetify = createVuetify({
    plugin,
    components,
    directives,
});

const app = createApp({});

app.component("example-component", ExampleComponent);
app.component("test-component", TestComponent);
app.component("profile-show", ProfileShow);
app.component("profile-update", ProfileUpdate);
app.component("profile", Profile);
app.component("team-update", TeamUpdate);
app.component("team-show", TeamShow);
app.component("team-index", TeamIndex);
app.component("contractor-index", ContractorIndex);
app.component("contractor-update", ContractorUpdate);
app.component("contractor-show", ContractorShow);
app.component("event-update", EventUpdate);
app.component("event-show", EventShow);
app.component("event-index", EventIndex);
app.component("place-update", PlaceUpdate);
app.component("place-show", PlaceShow);
app.component("place-index", PlaceIndex);
app.component("tournament-update", TournamentUpdate);
app.component("tournament-index", TournamentIndex);
app.component("tournament-show", TournamentShow);

app.use(vuetify).mount("#app");
