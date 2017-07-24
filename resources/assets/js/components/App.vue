<template>
    <div style="display:flex;flex-direction:row">
        <div style="flex:1">
            <widget-list></widget-list>
        </div>
        <div style="flex:5">
            <content-area></content-area>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import { mapGetters, mapActions } from 'vuex'

    export default {
        mounted() {
            this.$store.dispatch('loadTemplate', { id: window.template_id });
        }
    }
</script>
