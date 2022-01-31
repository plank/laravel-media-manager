<template>
  <div v-if="slideOpen" class="mm__slidepanel">
    <div v-if="this.$store.state.isLoadingSidePanel" class="loader__overlay">
      <div class="loader"></div>
    </div>
    <a href="" class="mm__slidepanel-close" v-on:click.prevent="close()">
      <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M21.598.402a1.362 1.362 0 00-1.934 0L11 9.066 2.336.402a1.362 1.362 0 00-1.934 0 1.362 1.362 0 000 1.933L9.067 11 .402 19.662a1.362 1.362 0 000 1.933c.264.263.618.405.962.405s.698-.132.962-.405l8.664-8.663 8.664 8.663c.263.263.618.405.962.405.354 0 .698-.132.961-.405a1.362 1.362 0 000-1.933L12.933 11l8.665-8.664a1.362 1.362 0 000-1.933z"
          fill-rule="nonzero"
          fill="#000"
        />
      </svg>
    </a>

    <div>
      <img
        v-if="this.data.aggregate_type === 'image'"
        width="100%"
        :src="this.data.url"
        alt=""
      />
      <div v-else-if="this.data.aggregate_type === 'video'" class="video-player">
        <video width="100%" height="240" controls>
          <source :src="this.data.url" type="video/mp4" />
          <source :src="this.data.url" type="video/ogg" />
          Your browser does not support the video tag.
        </video>
      </div>
      <div v-else-if="this.data.aggregate_type === 'audio'" class="audio-player">
        <audio controls>
          <source :src="this.data.url" type="audio/ogg" />
          <source :src="this.data.url" type="audio/mpeg" />
          Your browser does not support the audio element.
        </audio>
      </div>
      <div class="mm_slidepanel-placeholder-container" v-else>
        <div class="placeholder">{{ this.data.extension }}</div>
      </div>
    </div>

    <div v-if="this.$props.showLang" class="mm__slidepanel-lang">
      <div></div>
      <div class="mm__slidepanel-lang-container">
        <div>
          <span>EN</span>
        </div>
        <div>
          <label class="switch">
            <input
              @change="setLang"
              true-value="fr"
              false-value="en"
              v-model="langSwitch"
              type="checkbox"
            />
            <span class="switch-slider round"></span>
          </label>
        </div>
        <div>
          <span>FR</span>
        </div>
      </div>
    </div>

    <div class="mm__slidepanel-infos">
      <h5>{{ this.data.filename }}</h5>
      <p>
        Type: <span>{{ this.data.mime_type }}</span>
      </p>
      <p>
        File Size: <span>{{ fileSize }}</span>
      </p>
      <p>
        Upload Date:
        <span>{{ this.data.created_at | moment("MMMM Do, YYYY") }}</span>
      </p>
      <div class="mm__slidepanel-infos__buttons">
        <button :style="styleBtnDefault"  class="btn btn-default" v-on:click="copyImageHtml(data)">Copy Html</button>
        <button v-if="data.isAttached" :style="styleBtnDefault"  class="btn btn-default" 
        v-on:click="removeAttachment(data, tag, model, model_id)">Remove attachment</button>
      </div>
      <form id="media__update" action="">
        <div>
          <label for="title">{{ $t("slidepanel.title") }}</label>
          <input v-model="title" id="title" type="text" />
        </div>
        <div>
          <label for="alt">{{ $t("slidepanel.alt_text") }}</label>
          <input v-model="alt" id="alt" type="text" />
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
            v-on:click.prevent="close($event)"
            href=""
            >{{ $t('actions.close') }}</a
          >
        </div>
        <div class="columns__1">
          <a
            @click.prevent="openDeleteModal"
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
import fileSizeFilter from "../../helpers/filter.js";

export default {
  name: "mmslidepanel",
  props: {
    showLang: {
      type: Boolean,
    },
    model: {
      type: String,
    },
    model_id: {
      type: String,
    },
    tag: {
      type: String,
    }
  },
  data() {
    return {
      slideOpen: false,
      langSwitch: "",
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
    setLang: function () {
      this.$store.dispatch("setLang", this.langSwitch);
    },
    close: function () {
      this.slideOpen = false;
    },
    openDeleteModal: function () {
      this.$store.dispatch("openModalDelete");
      this.slideOpen = false;
    },
    updateMedia: function () {
      this.$store.dispatch("updateMedia", {
        locale: this.langSwitch,
        vm: this,
        disk: this.disk,
        id: this.id,
        title: this.title,
        alt: this.alt,
        credit: this.credit,
        caption: this.caption,
      });
    },
    selectFile: function () {
        handleContent(this.$store.state.selectedElem);
        this.close();
    },
    copyImageHtml: function(image) {
      let imageHtml = '<div><img src="' + image.url + '" alt="' + image.alt + '"/> </div>';
      let dummyTextarea = document.createElement( "textarea" ); 
      dummyTextarea.innerHTML = imageHtml;  
      document.body.appendChild( dummyTextarea ); 
      dummyTextarea.select(); 
      dummyTextarea.focus(); 
  
      try { 
          let success = document.execCommand( "copy" ); 
          if (success) {
            this.$toast.open({
              type: "success",
              position: "bottom-left",
              message: this.$i18n.t("actions.copyToClipboard"),
            });
        }
      } catch( e ) { 
        this.$toast.open({
          type: "error",
          position: "bottom-left",
          message: this.$i18n.t("actions.copyToClipboard"),
        });
      } 
      document.body.removeChild(dummyTextarea);  
    },
    removeAttachment: function(media, tag, model, model_id) {
      let imageToRemove = {
        model: `App\\Models\\${this.capitalize(model)}`,
        model_id: model_id,
        tag: tag,
        media: media.id
      };
      this.$store.dispatch("removeAttachedMedia", imageToRemove)
    },
    capitalize(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  mounted() {
    EventBus.$on("open-slide-panel", (value) => {
      this.slideOpen = true;
      this.data = value;
      this.disk = this.data.disk;
      this.id = this.data.id;
      this.alt = this.data.alt;
      this.title = this.data.title;
      this.credit = this.data.credit;
      this.caption = this.data.caption;
    });
    EventBus.$on("close-slide-panel", () => {
      this.slideOpen = false;
      this.data = null;
      this.disk = null;
      this.id =  null; 
      this.title = null;
      this.credit = null;
      this.caption = null;
    });

    this.langSwitch = this.$store.state.lang;
  },
  watch: {
    getSelectedTranslation() {
      this.data = this.$store.state.selectedTranslation;
      this.disk = this.data.disk;
      this.id = this.data.id;
      this.title = this.data.title;
      this.alt = this.data.alt;
      this.credit = this.data.credit;
      this.caption = this.data.caption;
    },
    getSelectedLang(newLang, oldLang) {
      this.$store.dispatch("getTranslatedDirectory", this.data.id);
    },
  },
  computed: {
    fileSize() {
      return fileSizeFilter(this.data.size);
    },
    getSelectedTranslation() {
      return this.$store.state.selectedTranslation;
    },
    getSelectedLang() {
      return this.$store.state.lang;
    },
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
