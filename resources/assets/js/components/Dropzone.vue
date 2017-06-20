<template>
    <div class="dropzone">
        <h1>Content Area</h1>
        <div class="drag">
            <h2>List 2 Draggable</h2>
            <draggable v-model="list2" class="dragArea" :options="{group:'people'}" @add="onAdded" @change="onAdded">
                <div v-for="(element, index) in list2" :key="index" v-html="element.widget"></div>
            </draggable>
        </div>

        <div class="normal">
            <h2>Static</h2>
            <div class="dragArea">
                <div v-for="element in list2">{{element.widget}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    let contents = [{name: 'first one', widget: '{{blahblah}}'}];

    export default {
        data() {
            return {
                list2: contents
            }
        },
        mounted() {
            console.log('Draggable mounted.')
        },
        methods: {
            onAdded(event) {
                if (typeof event.added === 'undefined') {
                    return;
                }
                const element = event.added.element;
                contents.push(element);
            }
        },
        components: {
            draggable
        }
    }
</script>

<style lang="scss">
    .dropzone {
        background-color:#ccc;
    }
</style>
