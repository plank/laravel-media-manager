<template>
    <div class="mm__results">
        <div
            v-if="this.$store.state.hideDirectory == false"
            class="mm__results-grid"
        >
            <div
                v-for="(item, index) in getDir"
                :key="index"
                class="mm__results-single"
                v-bind:class="[cardItem == index ? 'active' : '']"
                v-on:click="showOptions(index, item)"
                v-on:dblclick="openDirectory($event, item)"
                @contextmenu.prevent.stop="handleClick($event, item)"
            >
                <mmfoldercard :item="item"></mmfoldercard>
            </div>
        </div>

        <vue-simple-context-menu
            :elementId="'myUniqueId'"
            :options="optionsArray1"
            :ref="'vueSimpleContextMenu'"
            @option-clicked="optionClicked"
        />
    </div>
</template>

<script>
import mmfoldercard from './mm-card-folder'

export default {
    name: 'mmfolders',
    components: {
        mmfoldercard
    },
    data () {
        return {
            current: null,
            cardItem: null,
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
                    name: 'Move',
                    slug: 'move'
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
            } else if (JSON.stringify(event.option.slug) === '"move"') {
                this.$store.state.selectedDirectory = event.item
                this.$store.dispatch('OPEN_MOVE_MODAL')
                // EventBus.$emit('open-slide-panel', [event.item]);
            }
        },
        // Open Directory
        // Set activeDirectory and open in relation
        openDirectory: function (event, value) {
            this.current = value.name
            this.$store.dispatch('SET_SELECTED_DIRECTORY', null)
            this.$store.dispatch('GET_DIRECTORY', value.name)
        },
        showOptions (index, item) {
            this.cardItem = index
            this.$store.dispatch('SET_SELECTED_DIRECTORY', item)
        },
        goBack ($event) {
            $event.preventDefault()
            let directoryTarget = null
            const directoryLevel = this.current.split('/')

            if (directoryLevel.length > 1) {
                // Get second last item on arrau
                directoryTarget = directoryLevel[directoryLevel.length - 2]
            } else {
                directoryTarget = ''
            }

            this.openDirectory($event, directoryTarget)
        }
    },
    computed: {
        getDir () {
            return this.$store.getters.GET_DIRECTORY
        }
    },
    mounted () {
        this.$store.dispatch('GET_DIRECTORY')
    }
}
</script>
