<template>
	<mmmodal extraClassContainer="modal-delete-file">
		<h2 slot="title">{{ $t("modal.title_deleteFile") }}</h2>

		<div slot="content">
			<div class="content-grid">
				<div>
					<div class="illustration__trash"></div>

					<p>{{ $t("modal.confirmation_msg_media") }}</p>
					
				</div>
			</div>
		</div>

		<div class="buttons__container-wrapper" slot="buttons">
			<button :style="styleBtnDefault" class="btn btn-default" v-on:click.prevent="deleteElement">{{ $t("actions.yes") }}</button>
			<button @click.prevent="closeModal" class="btn btn-default-border" :style="styleBtnDefault">{{ $t("actions.cancel") }}</button>
		</div>
	</mmmodal>
</template>

<script>
import mmmodal from "./../mm-modal"

export default {
	name: "ModalDeleteFile",
	components: {
		mmmodal,
	},
	methods: {
		closeModal: function() {
			this.$store.dispatch("closeModalDeleteFile")
		},
		deleteElement: function() {
			this.$store.dispatch("deleteSelected", {
				vm: this,
				file: [this.$store.state.modalState.deleteFile]
			})
		},
	},
	computed: {
		styleBtnDefault() {
			return {
				"--bg-color": this.$store.state.mainColor,
			}
		},
	},
}
</script>

<style lang="scss">
.btn-default {
	background: var(--bg-color);
	border-color: var(--bg-color);
	justify-content: center;

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

</style>
