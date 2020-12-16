<template>
  <div v-if="slideOpen" class="mm__slidepanel">
    <a href="" class="mm__slidepanel-close" v-on:click="close($event)">Close</a>

    <!-- Image Container -->
    <div>
      <img width="100%" src="https://source.unsplash.com/1600x900/?music" alt="" />
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
        Upload Date: <strong>{{ this.data[0].created_at }}</strong>
      </p>
      <!-- Form -->
      <form action="">
        <div>
          <label for="">{{ $t("slidepanel.alt_text") }}</label>
          <input type="text" />
        </div>
        <div>
          <label for="">{{ $t("slidepanel.credit") }}</label>
          <input type="text" />
        </div>
        <div>
          <label for="">{{ $t("slidepanel.caption") }}</label>
          <textarea />
        </div>
      </form>

      <div class="mm__slidepanel-btn-container">
        <div class="columns columns__2">
          <a :style="styleBtnDefault" class="btn btn-default" href="">Save</a>
          <a :style="styleBtnDefault" class="btn btn-default-border" href=""
            >Add Details</a
          >
        </div>
        <div class="columns__1">
          <a class="btn btn-delete text-center" :style="styleBtnDefault" href="@"
            >Delete file</a
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "./../event-bus.js";

export default {
  name: "mmslidepanel",
  data() {
    return {
      slideOpen: false,
      data: [],
    };
  },
  methods: {
    close: function (event) {
      event.preventDefault();
      this.slideOpen = false;
    },
  },
  mounted() {
    EventBus.$on("openSlidepanel", (value) => {
      this.slideOpen = true;
      this.data = value;
    });
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
