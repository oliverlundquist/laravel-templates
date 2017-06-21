<template>
    <div class="dropzone">
        <div class="drag">
            <draggable v-model="getWidgets" class="dragArea" :options="{group:'people'}" @change="addWidget">
                <div v-for="(element, index) in getWidgets" :key="index" v-html="element.html"></div>
            </draggable>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import { mapGetters, mapActions } from 'vuex'

    export default {
        computed: mapGetters(['getWidgets']),
        methods: {
            addWidget(event) {
                if (typeof event.added === 'undefined') {
                    return;
                }
                this.$store.dispatch('addWidget', event.added.element);
            }
        },
        components: {
            draggable
        }
    }
</script>

<style lang="scss">
    .dropzone {
        background-color:#eee;
        padding: 20px;
    }
</style>
