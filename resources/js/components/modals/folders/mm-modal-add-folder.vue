<template>
  <mmmodal extraClassContainer="modal-add-folder">
    <h2 slot="title">{{ $t("modal.title_createFolder") }}</h2>

    <div slot="content">
      <div class="content-grid">
        <div class="icon-container">
          <!-- This need to be here until we fix the assets import -->
          <svg
            width="278px"
            height="244px"
            viewBox="0 0 278 244"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
          >
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <g id="icon-upload" transform="translate(-11.000000, 0.000000)">
                <path
                  d="M217.686,9.337 C184.308,-13.672 140.321,7.307 119.439,56.195 L119.423,56.231 C118.44,58.533 116.771,60.307 114.569,61.361 C103.924,66.457 93.635,73.272 84.178,81.788 C40.295,121.3 30.91,182.416 63.215,218.295 C95.52,254.173 157.283,251.228 201.165,211.715 C223.679,191.444 237.112,165.485 240.494,140.166 C240.620392,139.179711 240.871049,138.213373 241.24,137.29 C260.882,88.872 250.56,31.998 217.686,9.337"
                  id="Path"
                  fill-opacity="0.04"
                  fill="#000000"
                  fill-rule="nonzero"
                ></path>
                <g id="Group" transform="translate(0.000000, 47.000000)">
                  <g
                    transform="translate(236.943757, 86.154320) rotate(18.000000) translate(-236.943757, -86.154320) translate(189.943757, 30.654320)"
                    fill-rule="nonzero"
                    id="Path"
                    stroke="#000000"
                    stroke-width="2"
                  >
                    <path
                      d="M92.4,35.654 L57.694,0.949 C57.0866378,0.341623938 56.2629496,3.5971226e-16 55.404,3.5971226e-16 L12.024,3.5971226e-16 C5.454,3.5971226e-16 0.108,5.346 0.108,11.916 L0.108,78.73 C0.108996509,80.0402247 0.898781818,81.2209676 2.10938255,81.7221021 C3.31998327,82.2232365 4.71323506,81.9461731 5.64,81.02 L24.17,62.488 L39.233,77.55 C40.4982928,78.8152641 42.5497072,78.8152641 43.815,77.55 L64.08,57.282 L87.817,81.02 C88.743858,81.9454593 90.1366462,82.2220688 91.3468097,81.7210249 C92.5569731,81.2199809 93.3466005,80.0397858 93.348,78.73 L93.348,37.944 C93.348,37.0850504 93.0063761,36.2613622 92.399,35.654 L92.4,35.654 Z"
                      fill="#FFFFFF"
                    ></path>
                    <path
                      d="M92.4,35.654 L57.694,0.949 C56.7673674,0.0223884082 55.373804,-0.254802077 54.1631127,0.246679345 C52.9524214,0.748160767 52.163,1.92955847 52.163,3.24 L52.163,29.268 C52.163,35.838 57.508,41.184 64.079,41.184 L90.107,41.184 C91.4170023,41.1835749 92.5978513,40.3943323 93.099242,39.1840788 C93.6006327,37.9738253 93.3238968,36.5807261 92.398,35.654 L92.4,35.654 Z"
                      fill="#EDECEC"
                    ></path>
                    <path
                      d="M12.024,110.592 C5.454,110.592 0.108,105.246 0.108,98.676 L0.108,78.729 C0.108,77.869 0.45,77.045 1.058,76.438 L21.88,55.615 C23.1452928,54.3497359 25.1967072,54.3497359 26.462,55.615 L41.522,70.675 L61.79,50.41 C62.3974435,49.8020122 63.2215603,49.46 64.081,49.46 L64.295,49.468 C65.076,49.519 65.815,49.853 66.372,50.41 L92.4,76.438 C93.0077428,77.0451985 93.35,77.8689069 93.35,78.728 L93.35,98.676 C93.35,103.73 90.186,108.06 85.735,109.789 L85.467,109.889 C84.207,110.344 82.848,110.592 81.433,110.592 L12.024,110.592 Z"
                      fill="#DADADA"
                    ></path>
                    <path
                      d="M29.376,19.947 C22.806,19.947 17.461,25.292 17.461,31.863 C17.461,38.433 22.806,43.779 29.376,43.779 C35.946,43.779 41.292,38.434 41.292,31.863 C41.292,25.293 35.946,19.947 29.376,19.947 Z"
                      fill="#EDECEC"
                    ></path>
                  </g>
                  <g
                    transform="translate(62.656257, 85.554357) scale(-1, 1) rotate(18.000000) translate(-62.656257, -85.554357) translate(15.656257, 30.054357)"
                    fill-rule="nonzero"
                  >
                    <path
                      d="M93.348,98.676 C93.348,103.124 90.898,107.01 87.278,109.057 L87.029,109.194 C85.307088,110.114224 83.3843797,110.594471 81.432,110.592009 L12.024,110.592009 C5.454,110.592009 0.108,105.246 0.108,98.676 L0.108,11.916 C0.108,5.346 5.454,0 12.024,0 L55.404,0 C56.2630931,0 57.0868015,0.342257206 57.694,0.95 L92.4,35.652 C93.0079878,36.2594435 93.35,37.0835603 93.35,37.943 L93.348,98.676 Z"
                      id="Path"
                      stroke="#000000"
                      stroke-width="2"
                      fill="#FFFFFF"
                    ></path>
                    <g
                      transform="translate(38.117000, 61.387000) scale(-1, 1) translate(-38.117000, -61.387000) translate(19.617000, 43.387000)"
                    >
                      <circle
                        id="Oval"
                        fill="#D8D8D8"
                        cx="6.98"
                        cy="29.784"
                        r="4.5"
                      ></circle>
                      <circle
                        id="Oval"
                        fill="#D8D8D8"
                        cx="30.351"
                        cy="25.812"
                        r="4.5"
                      ></circle>
                      <path
                        d="M36.081,0.342 C35.8421226,0.142656216 35.5271402,0.0595155084 35.221,0.115 L11.981,4.315 C11.481,4.405 11.118,4.84 11.118,5.348 L11.118,24.946 C9.96475861,23.9094881 8.46858724,23.3366682 6.918,23.338 C3.44020528,23.3418578 0.62185779,26.1602053 0.618,29.638 C0.618,33.112 3.444,35.938 6.918,35.938 C10.392,35.938 13.218,33.112 13.218,29.638 L13.218,13.925 L34.358,10.105 L34.358,21.797 C33.2051064,20.7596799 31.7088694,20.1861224 30.158,20.187 C26.6802053,20.1908578 23.8618578,23.0092053 23.858,26.487 C23.858,29.962 26.684,32.787 30.158,32.787 C33.632,32.787 36.458,29.962 36.458,26.487 L36.458,1.148 C36.458,0.837084268 36.3196531,0.542282132 36.081,0.343 L36.081,0.342 Z M6.918,33.838 C4.59954623,33.8352449 2.72075515,31.9564538 2.718,29.638 C2.718,27.322 4.602,25.438 6.918,25.438 C9.234,25.438 11.118,27.322 11.118,29.638 C11.118,31.954 9.234,33.838 6.918,33.838 L6.918,33.838 Z M13.218,11.791 L13.218,6.225 L34.358,2.405 L34.358,7.97 L13.218,11.79 L13.218,11.791 Z M30.158,30.688 C27.8395462,30.6852449 25.9607551,28.8064538 25.958,26.488 C25.958,24.172 27.842,22.288 30.158,22.288 C32.474,22.288 34.358,24.172 34.358,26.488 C34.358,28.804 32.474,30.688 30.158,30.688 L30.158,30.688 Z"
                        id="Shape"
                        fill="#000000"
                      ></path>
                    </g>
                    <path
                      d="M92.4,35.654 L57.694,0.949 C56.7673674,0.0223884082 55.373804,-0.254802077 54.1631127,0.246679345 C52.9524214,0.748160767 52.163,1.92955847 52.163,3.24 L52.163,29.268 C52.163,35.838 57.508,41.184 64.079,41.184 L90.107,41.184 C91.4170023,41.1835749 92.5978513,40.3943323 93.099242,39.1840788 C93.6006327,37.9738253 93.3238968,36.5807261 92.398,35.654 L92.4,35.654 Z"
                      id="Path"
                      stroke="#000000"
                      stroke-width="2"
                      fill="#EDECEC"
                    ></path>
                  </g>
                  <g
                    transform="translate(90.400000, 0.000000)"
                    stroke="#000000"
                    stroke-width="2"
                  >
                    <path
                      d="M129.5,137.05 C129.5,146.175 122.075,153.6 112.95,153.6 L16.55,153.6 C7.424,153.6 0,146.175 0,137.05 L0,16.55 C0,7.425 7.425,0 16.55,0 L76.8,0 C77.9934782,0 79.1380783,0.474088668 79.982,1.318 L128.182,49.518 C129.026004,50.3618594 129.5,51.5065 129.5,52.7 L129.5,137.05 Z"
                      id="Path"
                      fill="#FFFFFF"
                      fill-rule="nonzero"
                    ></path>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="20"
                      width="47"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="33"
                      width="47"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="46"
                      width="47"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="66"
                      width="100"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="79"
                      width="100"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="92"
                      width="100"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="106"
                      width="100"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <rect
                      id="Rectangle"
                      x="14.6"
                      y="119"
                      width="100"
                      height="5"
                      rx="2.5"
                    ></rect>
                    <path
                      d="M128.032,49.519 L79.832,1.319 C78.545137,0.0321211977 76.6098355,-0.352950912 74.9283811,0.343313891 C73.2469268,1.03957869 72.15,2.68008979 72.15,4.5 L72.15,40.65 C72.15,49.775 79.574,57.2 88.7,57.2 L124.85,57.2 C126.669653,57.2 128.309985,56.1033794 129.006416,54.4222722 C129.702846,52.741165 129.318293,50.8060853 128.032,49.519 L128.032,49.519 Z"
                      id="Path"
                      fill="#ECEBEB"
                      fill-rule="nonzero"
                    ></path>
                  </g>
                  <circle
                    id="Oval"
                    stroke="#000000"
                    stroke-width="2"
                    fill="#FFFFFF"
                    fill-rule="nonzero"
                    cx="154.75"
                    cy="150.75"
                    r="18.75"
                  ></circle>
                  <path
                    d="M156.107,149.86 C155.959377,149.860001 155.839551,149.740622 155.839,149.593 L155.839,143.7 L153.161,143.7 L153.161,149.593 C153.161,149.741 153.041,149.861 152.893,149.861 L147,149.861 L147,152.539 L152.893,152.539 C153.041,152.539 153.161,152.659 153.161,152.807 L153.161,158.7 L155.839,158.7 L155.839,152.807 C155.839,152.659 155.959,152.539 156.107,152.539 L162,152.539 L162,149.861 L156.107,149.861 L156.107,149.86 Z"
                    id="Path"
                    stroke="#000000"
                    stroke-width="1.1"
                    fill="#000000"
                    fill-rule="nonzero"
                    stroke-linejoin="round"
                  ></path>
                </g>
                <circle
                  id="Oval"
                  fill="#DADADA"
                  fill-rule="nonzero"
                  cx="76.975"
                  cy="46.478"
                  r="3.5"
                ></circle>
                <circle
                  id="Oval"
                  fill="#DADADA"
                  fill-rule="nonzero"
                  cx="110.975"
                  cy="22.478"
                  r="7.5"
                ></circle>
                <circle
                  id="Oval"
                  fill="#DADADA"
                  fill-rule="nonzero"
                  cx="228.975"
                  cy="217.478"
                  r="7.5"
                ></circle>
              </g>
            </g>
          </svg>
        </div>
        <div class="input-group">
          <div class="centered">
            <div class="group">
              <label for="folder-name" class="form__label">{{
                $t("modal.folder_name")
              }}</label>
              <input v-model="name" type="text" id="name" required="required" />
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
          v-on:click="createDirectory($event)"
          href=""
          >{{ $t("actions.create") }}</a
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
import mmmodal from "./../mm-modal";
import mmiconbase from "./../../mm-icon-base";
import iconaddfolder from "./../../icons/icon-add-folder.vue";

export default {
  name: "mmmodaladdfolder",
  components: {
    mmmodal,
    mmiconbase,
    iconaddfolder,
  },
  data() {
    return {
      name: null,
    };
  },
  mounted() {},
  methods: {
    createDirectory: function ($event) {
      $event.preventDefault();
      const createFolderPath = () => {
        if (this.$store.state.currentDirectory) {
          this.$store.dispatch(
            "createDirectory",
            this.$store.state.currentDirectory + "/" + this.name
          );
        } else {
          this.$store.dispatch("createDirectory", this.name);
        }
      };

      return createFolderPath();
    },
    closeModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch("closeModalCreate");
    },
    uploadSuccess: function () {
      this.$store.dispatch("closeModalCreate");
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
    border: var(--bg-color)
    color: var(--bg-color)
    &:hover
        background: var(--bg-color)
        color: white
        transition: all 0.2s ease-in-out

.btn-delete
    color: var(--bg-color)
</style>
