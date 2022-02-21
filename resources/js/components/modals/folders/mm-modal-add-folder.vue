<template>
  <mmmodal extraClassContainer="modal-add-folder">
    <h2 slot="title">{{ $t("modal.title_createFolder") }}</h2>

    <div slot="content">
      <div class="content-grid">
        <div class="icon-container">
          <div class="illustration__folder"></div>
        </div>
        <div class="input-group">
          <div class="centered">
            <div class="group">
              <label for="folder-name" class="form__label">{{
                $t("modal.folder_name")
              }}</label>
              <input v-model="name" type="text" id="name" required="required"  @keydown.space.prevent />
              <div class="bar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="buttons__container-wrapper" slot="buttons">
      <div>
        <a
          :style="styleBtnDefault"
          v-bind:disabled="!name"
          class="btn btn-default"
          v-on:click.prevent="createDirectory"
          href=""
          >{{ $t("actions.create") }}</a
        >
      </div>
      <div>
        <a
          v-on:click.prevent="closeModal"
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
  name: "mmmodaladdfolder",
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
    createDirectory: function () {
      const createFolderPath = () => {
        if (this.$store.state.currentDirectory) {
          this.$store.dispatch("createDirectory", {
            vm: this,
            name: this.$store.state.currentDirectory + "/" + this.name,
          });
        } else {
          this.$store.dispatch("createDirectory", {
            vm: this,
            name: this.name,
          });
        }
      };

      return createFolderPath();
    },
    closeModal: function () {
      this.$store.dispatch("closeModalCreate");
    },
    uploadSuccess: function () {
      this.$store.dispatch("closeModalCreate");
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
		background: white;
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
		color: white;
		transition: all 0.2s ease-in-out;
	}
}

.btn-delete {
	color: var(--bg-color);
}
</style>
