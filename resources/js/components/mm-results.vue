<template>
    <div class="mm__results">
        <div class="mm__results-grid">
            <div
                v-for="item in getMedia"
                :key="item.id"
                class="mm__results-single"
                @contextmenu.prevent.stop="handleClick($event, item)"
            >
                <mmcard :data-type="item.aggregate_type" :item="item"></mmcard>
            </div>
            <div
                class="mm__search-no-result"
                v-if="getMedia.length == 0 && this.$store.state.hideDirectory"
            >
                <h3>{{ $t('search.no_result') }}</h3>
            </div>
        </div>
        <vue-simple-context-menu
            :elementId="'CardElement'"
            :options="optionsArray1"
            :ref="'vueSimpleContextMenu'"
            @option-clicked="optionClicked"
        />
    </div>
</template>

<script>
import { EventBus } from '../event-bus.js'
import mmcard from './mm-card'

export default {
    name: 'mmresults',
    components: {
        mmcard
    },
    data () {
        return {
            mediaCollection: this.$store.state.mediaCollection,
            optionsArray1: [
                {
                    name: this.$i18n.t('actions.delete'),
                    slug: 'delete',
                    class: 'delete-class'
                },
                {
                    type: 'divider'
                },
                {
                    name: this.$i18n.t('actions.more_details'),
                    slug: 'details'
                }
            ]
        }
    },
    methods: {
        handleClick (event, item) {
            this.$refs.vueSimpleContextMenu.showMenu(event, item)
        },
        optionClicked (event) {
            this.$store.state.selectedElem.push(event.item)
            if (JSON.stringify(event.option.slug) === '"delete"') {
                this.$store.dispatch('OPEN_MODAL_DELETE')
            } else if (JSON.stringify(event.option.slug) === '"details"') {
                EventBus.$emit('open-slide-panel', [event.item])
            }
        }
    },
    computed: {
        getMedia () {
            return this.$store.state.mediaCollection
        }
    }
}
</script>
