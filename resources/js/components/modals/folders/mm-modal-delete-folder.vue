<template>
  <mmmodal extraClassContainer="modal-delete-folder">
    <h2 slot="title">{{ $t("modal.title_deleteFolder") }}</h2>

    <div slot="content">
      <div class="content-grid">
        <div>
          <div class="illustration__trash"></div>
          <p>
            {{ $t("modal.confirmation_msg") }}
          </p>
        </div>
      </div>
    </div>

    <div class="buttons__container-wrapper" slot="buttons">
      <div>
        <!-- v-on:click="deleteSelectedMedia($event)" -->
        <a
          :style="styleBtnDefault"
          class="btn btn-default"
          v-on:click="deleteElement($event)"
          href=""
          >{{ $t("actions.yes") }}</a
        >
      </div>
      <div>
        <a
          v-on:click="closeModal($event)"
          class="btn btn-default-border text-center"
          :style="styleBtnDefault"
          href=""
          >{{ $t("actions.cancel") }}</a
        >
      </div>
    </div>
  </mmmodal>
</template>

<script>
import mmmodal from "./../mm-modal";

export default {
  name: "mmmodaldeletefolder",
  components: {
    mmmodal,
  },
  data() {
    return {
      name: null,
    };
  },
  mounted() {},
  methods: {
    closeModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch("CLOSE_MODAL_DELETE");
    },
    deleteElement: function ($event) {
      // Delete selected folder
      $event.preventDefault();
      this.$store.dispatch("DELETE_SELECTED", {
        vm: this,
        folder: this.$store.state.selectedDirectory,
        mediaCollection: this.$store.state.selectedElem,
      });
    },
  },
  computed: {
    getDir() {
      return this.$store.getters.getDirectory;
    },
    // Get Main Color From Store
    getColor() {
      return this.$store.state.mainColor;
    },
    styleBtnDefault() {
      return {
        "--bg-color": this.$store.state.mainColor,
      };
    },
  },
};
</script>

<style lang="sass">
.btn-default
    background: var(--bg-color)
    border-color: var(--bg-color)
    &:hover
        background: white
        border-color: var(--bg-color)
        color: var(--bg-color)
        transition: all 0.2s ease-in-out

.btn-default-border
    border: 3px solid var(--bg-color)
    color: var(--bg-color)
    &:hover
        background: var(--bg-color)
        color: white
        transition: all 0.2s ease-in-out

.btn-delete
    color: var(--bg-color)
</style>
