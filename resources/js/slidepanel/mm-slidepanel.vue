<template>
    <div v-if="slideOpen" class="mm__slidepanel">
        <a href="" class="mm__slidepanel-close" v-on:click="close($event)">Close</a>

        <!-- Image Container -->
        <div>
            <img width="100%" src="https://source.unsplash.com/1600x900/?music" alt="">
        </div>
        <!-- Container Slidepanel -->
        <div class="mm__slidepanel-infos">
            <!-- Name -->
            <h5>london_street.jpg </h5>
            <!-- Type -->
            <p>Type: <strong>Image</strong></p>
            <!-- Dimension -->
            <p>Dimension: <strong>1920 X 1080</strong></p>
            <!-- File Size -->
            <p>File Size: <strong>1.3MB</strong></p>
            <!-- Upload Date -->
            <p>Upload Date: <strong>July 17, 2020</strong></p>
            <!-- Form -->
            <form action="">
                <div>
                    <label for="">{{ $t('slidepanel.alt_text') }}</label>
                    <input type="text">
                </div>
                <div>
                    <label for="">{{ $t('slidepanel.credit') }}</label>
                    <input type="text">
                </div>
                <div>
                    <label for="">{{ $t('slidepanel.caption') }}</label>
                    <input type="text">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { EventBus } from './../event-bus.js';

export default {
  name: 'mmslidepanel',
  data() {
    return {
        slideOpen: false
    };
  },
  methods: {
      close: function (event) {
          event.preventDefault();
          this.slideOpen = false;
      }
  },
  mounted () {
      EventBus.$on('openSlidepanel', value => {
          this.slideOpen = true;
      });
  }
};
</script>

