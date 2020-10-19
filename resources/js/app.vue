<template>
  <div class="mm">
    <div class="mm__header">
        <div class="wrapper">
            <h1>{{ $t('general.title') }}</h1>
        </div>
    </div>

    <div class="wrapper">
        <!-- Search Panel -->
        <mmsearch></mmsearch>

        <!-- Results Panel -->
        <mmresults></mmresults>
    </div>

    <!-- Slidepanel -->
    <transition name="slide-fade">
        <mmslidepanel></mmslidepanel>
    </transition>

  </div>
</template>

<script>
import mmsearch from './search/mm-search';
import mmresults from './results/mm-results';
import mmslidepanel from './slidepanel/mm-slidepanel';

export default {
    name: 'App',
    components: {
        mmsearch,
        mmresults,
        mmslidepanel
    },
    data() {
        return {
        };
    },
};
</script>
