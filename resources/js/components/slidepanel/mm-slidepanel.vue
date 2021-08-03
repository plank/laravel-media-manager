<template>
  <div v-if="slideOpen" class="mm__slidepanel">
    <a href="" class="mm__slidepanel-close" v-on:click.prevent="close">
      <svg
        width="22px"
        height="22px"
        viewBox="0 0 22 22"
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
      >
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="icon_cancel_default" :fill="getColor" fill-rule="nonzero">
            <path
              d="M21.5976567,0.402297444 C21.0611867,-0.134099148 20.2008278,-0.134099148 19.66437,0.402297444 L11,9.06567624 L2.33563,0.402297444 C1.79917222,-0.134099148 0.938813333,-0.134099148 0.402343333,0.402297444 C-0.134114444,0.938706259 -0.134114444,1.79896725 0.402343333,2.33536384 L9.06671333,10.9987304 L0.402343333,19.6621092 C-0.134114444,20.1985058 -0.134114444,21.0587668 0.402343333,21.5951756 C0.665512222,21.8583078 1.01978556,22 1.36392667,22 C1.70808,22 2.06234111,21.8684278 2.32551,21.5951756 L10.98988,12.9317968 L19.65425,21.5951756 C19.9174189,21.8583078 20.27168,22 20.6158211,22 C20.9700944,22 21.3142356,21.8684278 21.5774044,21.5951756 C22.1138744,21.0587668 22.1138744,20.1985058 21.5774044,19.6621092 L12.9332867,10.9987304 L21.5976567,2.33536384 C22.1341144,1.79896725 22.1341144,0.938706259 21.5976567,0.402297444 Z"
            ></path>
          </g>
        </g>
      </svg>
    </a>

    <div>
      <img
        v-if="this.data[0].aggregate_type === 'image'"
        width="100%"
        :src="this.data[0].url"
        alt=""
      />
      <div v-else-if="this.data[0].aggregate_type === 'video'" class="video-player">
        <video width="100%" height="240" controls>
          <source :src="this.data[0].url" type="video/mp4" />
          <source :src="this.data[0].url" type="video/ogg" />
          Your browser does not support the video tag.
        </video>
      </div>
      <div v-else-if="this.data[0].aggregate_type === 'audio'" class="audio-player">
        <audio controls>
          <source :src="this.data[0].url" type="audio/ogg" />
          <source :src="this.data[0].url" type="audio/mpeg" />
          Your browser does not support the audio element.
        </audio>
      </div>
      <div class="mm_slidepanel-placeholder-container" v-else>
        <div class="placeholder">{{ this.data[0].extension }}</div>
      </div>
    </div>

    <div class="mm__slidepanel-infos">
      <h5>{{ this.data[0].filename }}</h5>
      <p>
        Type: <span>{{ this.data[0].mime_type }}</span>
      </p>
      <p>
        File Size: <span>{{ this.data[0].size | fileSize }}</span>
      </p>
      <p>
        Upload Date:
        <span>{{ this.data[0].created_at | moment("MMMM Do, YYYY") }}</span>
      </p>
      <form id="media__update" action="">
        <div>
          <label for="title">{{ $t("slidepanel.title") }}</label>
          <input v-model="title" value="" id="title" type="text" />
        </div>
        <div>
          <label for="alt">{{ $t("slidepanel.alt_text") }}</label>
          <input v-model="alt" value="" id="alt" type="text" />
        </div>
        <div>
          <label for="caption">{{ $t("slidepanel.caption") }}</label>
          <textarea v-model="caption" id="caption" />
        </div>
        <div>
          <label for="credit">{{ $t("slidepanel.credit") }}</label>
          <input v-model="credit" id="credit" type="text" />
        </div>
      </form>

      <div class="mm__slidepanel-btn-container">
        <div class="columns__2">
          <a
            :style="styleBtnDefault"
            class="btn btn-default"
            v-on:click.prevent="updateMedia"
            href=""
            >{{ $t('actions.save') }}</a
          >
          <a
            :style="styleBtnDefault"
            class="btn btn-default"
            v-on:click="close($event)"
            href=""
            >{{ $t('actions.close') }}</a
          >
        </div>
        <div class="columns__1">
          <a
            v-on:click.prevent="openDeleteModal"
            :title="$t('actions.delete')"
            class="btn btn-delete text-center"
            :style="styleBtnDefault"
            href="#"
            >{{ $t('actions.delete_file') }}</a
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../event-bus.js";

export default {
  name: "mmslidepanel",
  data() {
    return {
      slideOpen: false,
      data: [],
      disk: "",
      id: "",
      title: "",
      alt: "",
      credit: "",
      caption: "",
    };
  },
  methods: {
    close: function () {
      this.slideOpen = false;
    },
    openDeleteModal: function () {
      this.$store.dispatch("openModalDelete");
      this.slideOpen = false;
    },
    updateMedia: function () {
      this.$store.dispatch("updateMedia", {
        vm: this,
        disk: this.disk,
        id: this.id,
        alt: this.alt,
        credit: this.credit,
        caption: this.caption,
      });
    },
  },
  mounted() {
    EventBus.$on("open-slide-panel", (value) => {
      this.slideOpen = true;
      this.data = value;
      this.disk = this.data[0].disk;
      this.id = this.data[0].id;
      this.alt = this.data[0].alt;
      this.credit = this.data[0].credit;
      this.caption = this.data[0].caption;
    });

    EventBus.$on("close-slide-panel", () => {
        this.slideOpen = false;
    });
  },
  computed: {
    getColor() {
      return this.$store.state.mainColor;
    },
    styleBtnDefault() {
      return {
        "--bg-color": this.$store.state.mainColor,
      };
    },
  },
  filters: {
    fileSize: function (fileSize) {
      var sizesPrefix = ["Bytes", "KB", "MB", "GB", "TB"];
      if (fileSize == 0) return "0 Byte";
      var i = parseInt(Math.floor(Math.log(fileSize) / Math.log(1024)));
      return Math.round(fileSize / Math.pow(1024, i), 2) + " " + sizesPrefix[i];
    },
  },
};
</script>

<style lang="scss" scoped>
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
