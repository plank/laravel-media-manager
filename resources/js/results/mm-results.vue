<template>
    <div class="mm__results">

        <!-- For Each Loop -->
        <div class="mm__results-grid">
            <div
                v-for="item in collection"
                :key="item.id"
                class="mm__results-single"
                v-bind:class="{'selected': current === item.id}"
                v-on:click="setCurrent($event, item.id)"
            >
                <mmcard></mmcard>
            </div>
        </div>

    </div>
</template>

<script>
import { EventBus } from './../event-bus.js';
import mmcard from './mm-card';

export default {
    name: 'mmresults',
    components: {
      mmcard
    },
    data() {
        return {
            current: null,
            collection: [
                {id: 1, name: 'item 1'},
                {id: 2, name: 'item 2'},
                {id: 3, name: 'item 3'},
                {id: 4, name: 'item 3'},
                {id: 5, name: 'item 3'},
                {id: 6, name: 'item 3'},
                {id: 7, name: 'item 3'},
                {id: 8, name: 'item 3'},
                {id: 9, name: 'item 3'},
            ]
        };
    },
    methods: {
        // Set Current State And Open Slidepanel
        setCurrent: function(event, id) {
            event.preventDefault();
            this.current = id;
            EventBus.$emit('openSlidepanel', this.current);
        }
    },
    mounted () {
    }
};
</script>

