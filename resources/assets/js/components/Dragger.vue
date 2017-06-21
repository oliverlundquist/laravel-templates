<template>
    <div class="dragger">
        <h1>Widget List</h1>
        <div class="drag">
            <draggable v-model="widgets" class="dragArea" :options="{group:{ name:'people', pull:'clone', put:false }}">
                <div v-for="(element, index) in widgets" class="widget" :key="index">{{element.name}}</div>
            </draggable>
        </div>
        <button class="btn btn-success" style="margin-top:20px" @click="save">Save</button>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import CategoryList from '../widgets/category-list'
    import RandomWidget from '../widgets/random-widget'

    export default {
        data() {
            console.log(CategoryList);
            return {
                widgets: [CategoryList, RandomWidget, RandomWidget, RandomWidget, RandomWidget]
            }
        },
        methods: {
            save() {
                axios.post('/save', { contents: [] })
                             .then((response) => { console.log(response); })
                             .catch((error) => { console.log(error); });
            }
        },
        components: {
            draggable
        }
    }
</script>

<style lang="scss">
    .dragger {
        box-shadow: 10px 0px 2px -6px rgba(207,207,207,1);
    }
    .drag {
        text-align: center;
    }
    .widget {
        padding: 3px;
        width: 80%;
        border: 1px solid #ccc;
        display: inline-block;
        margin-bottom: 10px;
        background-color: #fff;
        cursor: move;
    }
</style>
