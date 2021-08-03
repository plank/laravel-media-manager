<template>
  <mmmodal extraClassContainer="modal-delete-folder">
    <h2 slot="title">{{ $t("modal.title_deleteFolder") }}</h2>

    <div slot="content">
      <div class="content-grid">
        <div>
          <div class="illustration__trash"></div>

          <p v-if="this.$store.state.selectedDirectory">
            {{ $t("modal.confirmation_msg") }}
          </p>

          <div
            v-if="this.$store.state.selectedElem && !this.$store.state.selectedDirectory"
          >
            <div v-if="this.$store.state.selectedElem.length <= 1">
              <p>{{ $t("modal.confirmation_msg_medias") }}</p>
            </div>
            <div v-else>
              <p>{{ $t("modal.confirmation_msg_medias_multiple") }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="buttons__container-wrapper" slot="buttons">
      <div>
        <a
          :style="styleBtnDefault"
          class="btn btn-default"
          v-on:click.prevent="deleteElement"
          href=""
          >{{ $t("actions.yes") }}</a
        >
      </div>
      <div>
        <a
          @click.prevent="closeModal"
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
  methods: {
    closeModal: function () {
      this.$store.dispatch("closeModalDelete");
    },
    deleteElement: function () {
      this.$store.dispatch("deleteSelected", {
        vm: this,
        folder: this.$store.state.selectedDirectory,
        mediaCollection: this.$store.state.selectedElem,
      });
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

