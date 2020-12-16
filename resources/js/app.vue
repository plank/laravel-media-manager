<template>
  <div class="mm">
    <div class="mm__header">
      <div class="wrapper">
        <h1>{{ $t("general.title") }}</h1>
      </div>
    </div>

    <div class="wrapper">
      <!-- Search Panel -->
      <mmsearch></mmsearch>

      <!-- TO REMOVE -->
      <div class="debug">
        {{ this.$store.state.selectedElem }}
      </div>

      <!-- Folders List -->
      <mmfolders v-if="folderState && !viewState"></mmfolders>

      <!-- Results List -->
      <mmlistresults v-if="viewState && !folderState"></mmlistresults>

      <!-- Results Panel -->
      <mmresults v-if="!viewState && !folderState"></mmresults>

      <!-- Add Button -->
      <mmaddbutton></mmaddbutton>

      <!-- Carousel Panel -->
      <mmcarousel></mmcarousel>
    </div>

    <!-- Slidepanel -->
    <transition name="slide-fade">
      <mmslidepanel></mmslidepanel>
    </transition>

    <!-- Modal -->
    <transition name="fade">
      <mmmodaladd v-if="modalState" @close="this.$store.modalState = false"></mmmodaladd>
    </transition>

    <transition name="fade">
      <div
        v-if="modalState"
        @close="this.$store.modalState = false"
        class="overlay"
      ></div>
    </transition>
  </div>
</template>

<script>
import mmsearch from "./search/mm-search";
import mmresults from "./results/mm-results";
import mmslidepanel from "./slidepanel/mm-slidepanel";
import mmaddbutton from "./buttons/mm-add-button";
import mmmodaladd from "./modals/mm-modal-add";
import mmlistresults from "./results/mm-list-results";
import mmfolders from "./folders/mm-folders";
import mmcarousel from "./carousel/mm-carousel";

export default {
  name: "App",
  components: {
    mmsearch,
    mmresults,
    mmslidepanel,
    mmaddbutton,
    mmmodaladd,
    mmlistresults,
    mmfolders,
    mmcarousel,
  },
  data() {
    return {};
  },
  computed: {
    modalState() {
      return this.$store.state.modalState;
    },
    viewState() {
      return this.$store.state.viewState;
    },
    folderState() {
      return this.$store.state.folderState;
    },
  },
};
</script>
