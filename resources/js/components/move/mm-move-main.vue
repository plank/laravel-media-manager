<template>
    <div>
        <ul class="mm__move-folder-list">
            <li
                v-if="getDir.length || getDir.length == 0"
                class="mm__move-back"
                v-on:click="goBack($event)"
            >
                <a href="">{{ $t('actions.back') }}</a>
            </li>
            <li
                v-for="(item, index) in getDir"
                :key="index"
                v-bind:class="[folderIndex == index ? 'active' : '']"
            >
                <div class="mm__move-single">
                    <div class="mm__move-folder-title">
                        <a
                            v-on:click="selectElement($event, item, index)"
                            href="#"
                            >{{ item.name | clearname }}</a
                        >
                    </div>
                    <div class="mm__move-folder-handler">
                        <a v-on:click="goDeeper($event, item.name)" href="#"
                            >Enter</a
                        >
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import { EventBus } from '../../event-bus.js'
export default {
    name: 'mmmovemain',
    components: {},
    data () {
        return {
            current: null,
            folderIndex: null
        }
    },
    methods: {
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
            this.current = directoryTarget
            this.$store.dispatch('GET_MOVE_DIRECTORY', directoryTarget)
        },
        selectElement: function ($event, value, index) {
            $event.preventDefault()
            this.folderIndex = index
            EventBus.$emit('allow-move', value)
        },
        goDeeper: function ($event, value) {
            $event.preventDefault()
            this.current = value
            this.$store.dispatch('GET_MOVE_DIRECTORY', value)
        }
    },
    filters: {
        clearname: function (name) {
            name = name.split('/')
            return name[name.length - 1]
        }
    },
    mounted () {
        this.$store.dispatch('GET_MOVE_DIRECTORY')
    },
    computed: {
        getDir () {
            return this.$store.getters.getMoveDirectory
        }
    }
}
</script>
