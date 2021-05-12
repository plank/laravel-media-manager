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
          v-on:click.prevent="moveSelected"
          href=""
          >{{ $t("actions.move") }}</a
        >
      </div>
      <div>
        <a
          v-on:click.prevent="closeModal"
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
import { EventBus } from "../../event-bus.js";
import mmmodal from "./../modals/mm-modal";
import mmmovemain from "./mm-move-main";
export default {
  name: "mmmodalamovefolder",
  components: {
    mmmodal,
    mmmovemain,
  },
  data() {
    return {
      selectedFolder: null,
    };
  },
  mounted() {
    EventBus.$on("allowMove", (value) => {
      this.selectedFolder = value;
    });
  },
  methods: {
    moveSelected: function () {
      this.$store.dispatch("moveSelected", {
        vm: this,
        folder: this.$store.state.selectedDirectory,
        destination: this.selectedFolder,
        mediaCollection: this.$store.state.selectedElem,
      });
    },
    closeModal: function () {
      this.$store.dispatch("closeModalMove");
    },
  },
  computed: {
    styleBtnDefault() {
      return {
        "--bg-color": this.$store.state.mainColor,
      };
    },
  },
};
</script>

<style lang="scss">
.btn-default {
	background: var(--bg-color);
	border-color: var(--bg-color);

	&:hover {
		background: #fff;
		border-color: var(--bg-color);
		color: var(--bg-color);
		transition: all 0.2s ease-in-out;
	}
}

.btn-default-border {
	border: var(--bg-color);
	color: var(--bg-color);

	&:hover {
		background: var(--bg-color);
		color: #fff;
		transition: all 0.2s ease-in-out;
	}
}

.btn-delete {
	color: var(--bg-color);
}
</style>
