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

        <!-- we use  a hidden input to get the tag value -->
        <input id="tag" type="hidden" />
        <input id="attachedMedia" type="hidden" />

        <div class="wrapper" v-on:click="triggerClick($event)">
            <!-- Search Panel -->
            <mmsearch :resetPageNumber="resetPageNumber"></mmsearch>

            <!-- Folders List -->
            <mmfolders v-if="folderState && !viewState" :resetPageNumber="resetPageNumber" ></mmfolders>

            <!-- Results List -->
            <mmlistresults v-if="viewState && !folderState"></mmlistresults>

            <!-- Results Panel -->
            <mmresults></mmresults>

            <!-- Attach Button -->
            <mmattachbutton
                v-if="
                    this.$store.state.selectedElem.length > 0 &&
                        showAttach &&
                        tag !== ''
                "
                v-bind:selectedElem="this.$store.state.selectedElem"
                v-bind:model="this.$props.model"
                v-bind:model_id="this.$props.model_id"
                v-bind:tag="tag"
            ></mmattachbutton>

            <!-- Add Button -->
            <mmaddbutton></mmaddbutton>

            <!-- Carousel Panel -->
            <mmcarousel v-if="tag == ''"></mmcarousel>
        </div>

        <!-- Slidepanel -->
        <span name="slide-fade">
            <mmslidepanel  
            :showLang="this.$props.showLang" 
            :model="this.$props.model"
            :model_id="this.$props.model_id"
            :tag="tag"
            ></mmslidepanel>
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

        <button v-on:click="loadMore" :disabled="this.$store.state.allMediaLoaded" :style="styleBtnDefault" class="btn btn-default btn-load-more" >
            <span v-if="!this.$store.state.allMediaLoaded">Load more</span>
            <span v-else> All media loaded</span>
        </button>
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
import mmattachbutton from "./mm-attach-button";
import { EventBus } from "../event-bus";

export default {
    name: "media-manager",
    props: {
        showLang: {
            type: Boolean,
            required: false,
            default: true
        },
        model: {
            type: String,
            required: false
        },
        model_id: {
            type: String, // it should be Number but because its coming through data attributes its a string
            required: false
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
        mmattachbutton
    },
    data() {
        return {
            showAttach: !location.pathname.includes("media"),
            tag: "",
            pageNumber: 1
        };
    },
    mounted() {
        // we do this so we can reset the selected media when the modal is closed and reopened
        let selectButtons = Array.from(
            document.getElementsByClassName("select-media-btn")
        );
        selectButtons.forEach(button => {
            button.addEventListener("click", () => {
                this.$store.dispatch("resetSelected", true);
            });
        });
        let updataFunc = this.updateTag;
        let openAttachedMediaFunc = this.openAttachedMedia;
        // we do this because we need a way to keep track of the tag
        let tag = document.getElementById("tag");
        let attachedMedia = document.getElementById("attachedMedia");
        // mutation observer takes a call back that will excute when mutations are observed
        let observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === "attributes") {
                    if (mutation.target.attributes["data-tag"]) {
                        updataFunc(
                            mutation.target.attributes["data-tag"].value
                        );
                    } else if (
                        mutation.target.attributes["data-attachedmedia"]
                    ) {
                        openAttachedMediaFunc(
                            mutation.target.attributes["data-attachedmedia"]
                                .value
                        );
                    }
                }
            });
        });
        // note : we can also disconnect the oberver if needed
        observer.observe(tag, { attributes: true });
        observer.observe(attachedMedia, { attributes: true });
    },
    methods: {
        triggerClick: function($event) {
            if ($event.target.classList.contains("mm__results-grid")) {
                this.$store.dispatch("setSelectedDirectory", null);
                this.$store.dispatch("resetSelected", true);
                // close slidepane
                EventBus.$emit("close-slide-panel", false);
                const card = document.getElementsByClassName(
                    "mm__results-single"
                );
                for (let i = 0; i < card.length; i++) {
                    card.item(i).classList.remove("active");
                }
            }
        },
        updateTag: function(val) {
            this.tag = val;
        },
        openAttachedMedia: function(item) {
            let media = {...JSON.parse(item), isAttached: true}
            EventBus.$emit("open-slide-panel", media);
        },
        loadMore() {
            this.pageNumber++; // increament the pageNumber
            this.$store.dispatch("getDirectory", { 
            directory: this.$store.state.currentDirectory, 
            pageNumber: this.pageNumber, 
            lazyLoad: true
            });
        },
        resetPageNumber() {
            this.pageNumber = 1
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
        styleBtnDefault() {
            return {
                "--bg-color": this.$store.state.mainColor,
            }
        }
    }
};
</script>
