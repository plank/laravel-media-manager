<template>
  <div class="mm">
    <div class="mm__header">
      <div class="wrapper">
        <h1>{{ $t("general.title") }}</h1>
      </div>
    </div>

    <div class="wrapper">
      {{ store }}
      <!-- Search Panel -->
      <mmsearch></mmsearch>

      <!-- Results Panel -->
      <mmresults></mmresults>

      <!-- Add Button -->
      <mmaddbutton></mmaddbutton>
    </div>

    <!-- Slidepanel -->
    <transition name="slide-fade">
      <mmslidepanel></mmslidepanel>
    </transition>

    <!-- Modal -->
    <mmmodaladd v-if="showModal" @close="showModal = false"></mmmodaladd>
  </div>
</template>

<script>
import mmsearch from "./search/mm-search";
import mmresults from "./results/mm-results";
import mmslidepanel from "./slidepanel/mm-slidepanel";
import mmaddbutton from "./buttons/mm-add-button";
import mmmodaladd from "./modals/mm-modal-add";
import store from "./store.js";

export default {
  name: "App",
  components: {
    mmsearch,
    mmresults,
    mmslidepanel,
    mmaddbutton,
    mmmodaladd,
  },
  data() {
    return {
      showModal: false,
    };
  },
};
</script>
