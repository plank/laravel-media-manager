<template>
  <div class="mm">
    <div v-if="this.$store.state.isLoading" class="loader__overlay">
      <div class="loader"></div>
    </div>

    <div class="mm__header">
      <div class="wrapper">
        <h1>{{ $t("general.title") }}</h1>
      </div>
    </div>

    <div class="wrapper" v-on:click="triggerClick($event)">
      <!-- Search Panel -->
      <mmsearch></mmsearch>

      <!-- TO REMOVE -->
      <div class="debug">
        {{ this.$store.state.selectedElem }}
      </div>

      {{ info }}

      <!-- Folders List -->
      <mmfolders v-if="folderState && !viewState"></mmfolders>

      <!-- Results List -->
      <mmlistresults v-if="viewState && !folderState"></mmlistresults>

      <!-- Results Panel -->
      <mmresults></mmresults>

      <!-- Add Button -->
      <mmaddbutton></mmaddbutton>

      <!-- Carousel Panel -->
      <mmcarousel></mmcarousel>
    </div>

    <!-- Slidepanel -->
    <span name="slide-fade">
      <mmslidepanel></mmslidepanel>
    </span>

    <!-- Modal Add -->
    <transition name="fade">
      <mmmodaladd
        v-if="modalStateAddMedia"
        @close="this.$store.modalState.create = false"
      >
      </mmmodaladd>
    </transition>

    <div v-if="isEmpty">
      <mmempty></mmempty>
    </div>

    <!-- Modal Create Folder -->
    <transition name="fade">
      <mmmodaladdfolder
        v-if="modalStateCreateFolder"
        @close="this.$store.modalState.create = false"
      ></mmmodaladdfolder>
    </transition>

    <!-- Modal Move Folder -->
    <transition name="fade">
      <mmmodalmove
        v-if="modalStateMoveFolder"
        @close="this.$store.modalState.create = false"
      ></mmmodalmove>
    </transition>

    <!-- Modal Delete Folder -->
    <transition name="fade">
      <mmmodaldeletefolder
        v-if="modalStateDeleteFolder"
        @close="this.$store.modalState.delete = false"
      ></mmmodaldeletefolder>
    </transition>

    <!-- Overlay -->
    <transition name="fade">
      <div
        v-if="
          modalStateAddMedia ||
          modalStateCreateFolder ||
          modalStateDeleteFolder ||
          modalStateMoveFolder
        "
        @close="this.$store.modalState.add = false"
        class="overlay"
      ></div>
    </transition>
  </div>
</template>

<script>
import mmsearch from "./mm-search";
import mmresults from "./mm-results";
import mmslidepanel from "./slidepanel/mm-slidepanel";
import mmaddbutton from "./mm-add-button";
import mmmodaladd from "./modals/files/mm-modal-add";
import mmmodaladdfolder from "./modals/folders/mm-modal-add-folder";
import mmmodaldeletefolder from "./modals/folders/mm-modal-delete-folder";
import mmmodalmove from "./move/mm-modal-move";
import mmlistresults from "./mm-list-results";
import mmfolders from "./mm-folders";
import mmcarousel from "./carousel/mm-carousel";
import mmempty from "./mm-empty";

export default {
  name: "media-manager",
  components: {
    mmsearch,
    mmresults,
    mmslidepanel,
    mmaddbutton,
    mmmodaladd,
    mmlistresults,
    mmfolders,
    mmcarousel,
    mmmodaladdfolder,
    mmmodaldeletefolder,
    mmmodalmove,
    mmempty,
  },
  data() {
    return {
      info: null,
    };
  },
  methods: {
    triggerClick: function ($event) {
      if ($event.target.classList.contains("mm__results-grid")) {
        this.$store.dispatch("SET_SELECTED_DIRECTORY", null);
        this.$store.dispatch("RESET_SELECTED", true);
        const card = document.getElementsByClassName("mm__results-single");
        for (let i = 0; i < card.length; i++) {
          card.item(i).classList.remove("active");
        }
      }
    },
  },
  computed: {
    modalStateMoveFolder() {
      return this.$store.state.modalState.move;
    },
    modalStateCreateFolder() {
      return this.$store.state.modalState.create;
    },
    modalStateDeleteFolder() {
      return this.$store.state.modalState.delete;
    },
    modalStateAddMedia() {
      return this.$store.state.modalState.add;
    },
    viewState() {
      return this.$store.state.viewState;
    },
    folderState() {
      return this.$store.state.folderState;
    },
    isEmpty() {
      return (
        this.$store.state.directoryCollection.length === 0 &&
        this.$store.state.mediaCollection.length === 0
      );
    },
  },
};
</script>
