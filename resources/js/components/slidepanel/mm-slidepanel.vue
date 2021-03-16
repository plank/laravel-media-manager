<template>
  <div v-if="slideOpen" class="mm__slidepanel">
    <a href="" class="mm__slidepanel-close" v-on:click="close($event)">
      <!-- Info -->
      <mmiconbase
        icon-name="add-folder"
        current-color="#8B8B8B"
        icon-color="#8B8B8B"
        width="26"
        height="23"
        viewBox="0 0 20 23"
        ><iconclose></iconclose
      ></mmiconbase>
    </a>

    <!-- Media Container -->
    <div>
      <img
        v-if="this.data[0].aggregate_type === 'image'"
        width="100%"
        :src="this.data[0].url"
        alt=""
      />
      <div v-if="this.data[0].aggregate_type === 'video'" class="video-player">
        <video width="100%" height="240" controls>
          <source :src="this.data[0].url" type="video/mp4" />
          <source :src="this.data[0].url" type="video/ogg" />
          Your browser does not support the video tag.
        </video>
      </div>
      <div v-if="this.data[0].aggregate_type === 'audio'" class="audio-player">
        <audio controls>
          <source :src="this.data[0].url" type="audio/ogg" />
          <source :src="this.data[0].url" type="audio/mpeg" />
          Your browser does not support the audio element.
        </audio>
      </div>
    </div>
    <!-- Container Slidepanel -->
    <div class="mm__slidepanel-infos">
      <!-- Name -->
      <h5>{{ this.data[0].filename }}</h5>
      <!-- Type -->
      <p>
        Type: <strong>{{ this.data[0].mime_type }}</strong>
      </p>
      <!-- Dimension -->
      <p>
        Dimension: <strong>{{ this.data[0].size }}</strong>
      </p>
      <!-- File Size -->
      <p>
        File Size: <strong>{{ this.data[0].size }}</strong>
      </p>
      <!-- Upload Date -->
      <p>
        Upload Date:
        <strong>{{ this.data[0].created_at | moment("MMMM Do, YYYY") }}</strong>
      </p>
      <!-- Form -->
      <form id="media__update" action="">
        <div>
          <label for="">{{ $t("slidepanel.alt_text") }}</label>
          <input v-model="alt" value="" id="alt" type="text" />
        </div>
        <div>
          <label for="">{{ $t("slidepanel.credit") }}</label>
          <input v-model="credit" id="credit" type="text" />
        </div>
        <div>
          <label for="">{{ $t("slidepanel.caption") }}</label>
          <textarea v-model="caption" id="caption" />
        </div>
      </form>

      <div class="mm__slidepanel-btn-container">
        <div class="columns columns__2">
          <a :style="styleBtnDefault" class="btn btn-default" v-on:click="updateMedia($event)" href="">Save</a>
          <a :style="styleBtnDefault" class="btn btn-default-border" href=""
            >Add Details</a
          >
        </div>
        <div class="columns__1">
          <!-- <a v-on:click="openDeleteModal($event)" :title="$t('actions.delete')" class="btn btn-delete text-center" :style="styleBtnDefault" href="#"
            >Delete file</a
          > -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from '../../event-bus.js';
import mmiconbase from './../mm-icon-base.vue';
import iconclose from './../icons/icon-close.vue';

export default {
  name: 'mmslidepanel',
  components: {
    mmiconbase,
    iconclose
  },
  data () {
    return {
      slideOpen: false,
      data: [],
      disk: '',
      id: '',
      alt: '',
      credit: '',
      caption: ''
    };
  },
  methods: {
    close: function (event) {
      event.preventDefault();
      this.slideOpen = false;
    },
    openDeleteModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch('OPEN_MODAL_DELETE');
      this.slideOpen = false;
    },
    updateMedia: function ($event) {
      $event.preventDefault();
      this.$store.dispatch('UPDATE_MEDIA', {
        vm: this,
        disk: this.disk,
        id: this.id,
        alt: this.alt,
        credit: this.credit,
        caption: this.caption
      });
    }
  },
  mounted () {
    EventBus.$on('open-slide-panel', (value) => {
      this.slideOpen = true;
      this.data = value;
      this.disk = this.data[0].disk;
      this.id = this.data[0].id;
      this.alt = this.data[0].alt;
      this.credit = this.data[0].credit;
      this.caption = this.data[0].caption;
    });
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
