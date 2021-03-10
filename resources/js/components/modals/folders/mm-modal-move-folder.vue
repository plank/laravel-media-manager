<template>
  <mmmodal extraClassContainer="modal-move-folder">
    <h2 slot="title">{{ $t("modal.title_moveFolder") }}</h2>

    <div slot="content">
      <div class="content-grid">
        <div class="mm__move-container">
          <mmmovemain></mmmovemain>
        </div>
        <div class="input-group">
          <div class="centered">
            <div class="group"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="buttons__container-wrapper" slot="buttons">
      <div>
        <a
          :style="styleBtnDefault"
          v-bind:disabled="!selectedFolder"
          class="btn btn-default"
          v-on:click="moveDirectory($event)"
          href=""
          >{{ $t("actions.move") }}</a
        >
      </div>
      <div>
        <a
          v-on:click="closeModal($event)"
          class="btn btn-delete text-center"
          :style="styleBtnDefault"
          href=""
          >{{ $t("actions.cancel") }}</a
        >
      </div>
    </div>
  </mmmodal>
</template>

<script>
import { EventBus } from './../../../event-bus.js';
import mmmodal from './../mm-modal';
import mmmovemain from './../../move/mm-move-main';
import axios from 'axios';
export default {
  name: 'mmmodalamovefolder',
  components: {
    mmmodal,
    mmmovemain
  },
  data () {
    return {
      name: null,
      selectedFolder: null
    };
  },
  mounted () {
    EventBus.$on('allow-move', (value) => {
      this.selectedFolder = value;
    });
  },
  methods: {
    moveDirectory: function ($event) {
      $event.preventDefault();
      axios
        .post(this.$store.state.routeMoveDirectory, {
          source: this.$store.state.selectedDirectory.name,
          destination: this.selectedFolder.name
        })
        .then((response) => {
          this.$store.dispatch('CLOSE_MODAL');
          this.$toast.open({
            type: 'success',
            position: 'bottom-left',
            message: 'Folder moved successfully'
          });
          // Reload Current Directory
          this.$store.dispatch('GET_DIRECTORY', this.$store.state.currentDirectory);
        });
    },
    closeModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch('CLOSE_MOVE_MODAL');
    }
  },
  computed: {
    styleBtnDefault () {
      return {
        '--bg-color': this.$store.state.mainColor
      };
    }
  }
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
    border: var(--bg-color)
    color: var(--bg-color)
    &:hover
        background: var(--bg-color)
        color: white
        transition: all 0.2s ease-in-out

.btn-delete
    color: var(--bg-color)
</style>
