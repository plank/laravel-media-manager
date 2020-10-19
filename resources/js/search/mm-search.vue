<template>
    <div class="mm__search">
        <div class="mm__search-container">
            <input type="text" v-bind:placeholder="$t('search.input_placeholder')">
            <button class="mm__search-send" type="send">Send</button>
        </div>
        <div>
            <select class="mm__search-select" name="" id="">
                <option value="">{{ $t('search.by_type') }}</option>
                <!-- Loop Here -->
                <option value="">Option 1</option>
                <option value="">Option 2</option>
                <option value="">Option 3</option>
            </select>

            <select class="mm__search-select" name="" id="">
                <option value="">{{ $t('search.by_date') }}</option>
                <!-- Loop Here -->
                <option value="">Option 1</option>
                <option value="">Option 2</option>
                <option value="">Option 3</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
  name: 'mmsearch',
  data() {
    return {
    };
  },
  mounted () {
  }
};
</script>

