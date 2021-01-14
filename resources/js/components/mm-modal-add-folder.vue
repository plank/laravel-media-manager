<template>
  <mmmodal>
    <h2 slot="title">{{ $t("modal.title_createFolder") }}</h2>
    <p slot="content">
      <input v-model="name" type="text" />
    </p>
    <div slot="buttons">
      <div>
        <a
          :style="styleBtnDefault"
          class="btn btn-default"
          v-on:click="createFolder($event)"
          href=""
          >Create</a
        >
      </div>
      <div>
        <a class="btn btn-delete text-center" :style="styleBtnDefault" href="">Cancel</a>
      </div>
    </div>
  </mmmodal>
</template>

<script>
import mmmodal from './mm-modal';
export default {
  name: 'mmmodaladdfolder',
  components: {
    mmmodal
  },
  data () {
    return {
      name: null
    };
  },
  mounted () {},
  methods: {
    createFolder: function ($event) {
      $event.preventDefault();
      this.$store.dispatch('createFolder', this.name);
    },
    closeModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch('closeModalAdd');
    },
    uploadSuccess: function () {
      this.$store.dispatch('closeModalAdd');
    }
  },
  computed: {
    // Get Main Color From Store
    getColor () {
      return this.$store.state.mainColor;
    },
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
