<template>
  <div class="modal">
    <a v-on:click="closeModal($event)" href="#" class="modal-close">
      <svg width="22px" height="22px" viewBox="0 0 22 22" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="icon_cancel_default" :fill="getColor" fill-rule="nonzero">
            <path
              d="M21.5976567,0.402297444 C21.0611867,-0.134099148 20.2008278,-0.134099148 19.66437,0.402297444 L11,9.06567624 L2.33563,0.402297444 C1.79917222,-0.134099148 0.938813333,-0.134099148 0.402343333,0.402297444 C-0.134114444,0.938706259 -0.134114444,1.79896725 0.402343333,2.33536384 L9.06671333,10.9987304 L0.402343333,19.6621092 C-0.134114444,20.1985058 -0.134114444,21.0587668 0.402343333,21.5951756 C0.665512222,21.8583078 1.01978556,22 1.36392667,22 C1.70808,22 2.06234111,21.8684278 2.32551,21.5951756 L10.98988,12.9317968 L19.65425,21.5951756 C19.9174189,21.8583078 20.27168,22 20.6158211,22 C20.9700944,22 21.3142356,21.8684278 21.5774044,21.5951756 C22.1138744,21.0587668 22.1138744,20.1985058 21.5774044,19.6621092 L12.9332867,10.9987304 L21.5976567,2.33536384 C22.1341144,1.79896725 22.1341144,0.938706259 21.5976567,0.402297444 Z"
            ></path>
          </g>
        </g>
      </svg>
    </a>

    <div class="modal__container modal__container-upload">
        <vue-dropzone ref="myVueDropzone" :style="styleBtnDefault" v-on:vdropzone-success="uploadSuccess()" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
    </div>
  </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
export default {
  name: 'mmmodaladd',
  components: {
    vueDropzone: vue2Dropzone
  },
  data () {
    return {
      dropzoneOptions: {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 150,
        maxFilesize: 4.5,
        headers: { 'My-Awesome-Header': 'header value' }
      }
    };
  },
  mounted () {},
  methods: {
    closeModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch('closeModal');
    },
    uploadSuccess: function () {
      this.$store.dispatch('closeModal');
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
.vue-dropzone
    .dz-preview
        .dz-details
            background: var(--bg-color) !important
</style>
