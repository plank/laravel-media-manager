<template>
  <div class="mm" id="mm">
    <div v-show="this.$store.state.isLoading && this.$store.state.modalState.move == false" class="loader__overlay">
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
      <mmslidepanel :showLang="this.$props.showLang"></mmslidepanel>
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
import { EventBus } from '../event-bus';

export default {
  name: "media-manager",
  props: {
      showLang: {
          type: Boolean,
          required: false,
          default: true,
      }
  },
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
        scrollHandler: this.searchResultsInfiniteScroll(),
        atBottom: false, // Track whether we are at the bottom of the page for infinite scroll
        page: 1,
        mediaManagerContainer: document.getElementById("mm")
    }
  },
  mounted() {
    // Set the scroll handler for infinite scroll in search
    document.getElementById("mm").onscroll = this.scrollHandler;
  },
  methods: {
    triggerClick: function ($event) {
      if ($event.target.classList.contains("mm__results-grid")) {
        this.$store.dispatch("setSelectedDirectory", null);
        this.$store.dispatch("resetSelected", true);
        // close slidepane
        EventBus.$emit('close-slide-panel', false);
        const card = document.getElementsByClassName("mm__results-single");
        for (let i = 0; i < card.length; i++) {
          card.item(i).classList.remove("active");
        }
      }
    },
  },
  methods: {
    searchResultsInfiniteScroll() {
        return () => {
            let container = document.getElementById("mm");

            // if (this.atBottom) {
            //     return;
            // }

            this.atBottom =
                container.scrollHeight - container.scrollTop ==
                container.offsetHeight;

            if (this.atBottom) {
                this.page++; // increament the page
                console.log(
                    this.$store.state.currentDirectory,
                    "this.$store.state.currentDirectory"
                );
                this.$store.dispatch("getDirectory", {
                    directory: this.$store.state.currentDirectory,
                    page: this.page
                });
            } else {
                console.log("not at bottom of div with page " + this.page);
            }
        };
    }
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
   beforeDestroy() {
       // TO DO: add the correct remove listner
        // window.removeEventListener("onscroll", this.scrollHandler);
    }
};
</script>
