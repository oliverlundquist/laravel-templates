<template>
    <div class="dragger">
        <h1>Widget List</h1>
        <div class="drag">
            <draggable v-model="widgets" class="dragArea" :options="{group:{ name:'people', pull:'clone', put:false }}">
                <div v-for="(element, index) in widgets" class="widget" :key="index">{{element.name}}</div>
            </draggable>
        </div>
        <h1>Color Scheme</h1>
        <h4>Base Color</h4>
        <div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span v-bind:style="{ backgroundColor: '#' + colors.selected.base.code }" class="color-patch-with-label"></span>{{colors.selected.base.name}} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li v-for="(color, index) in colors.base" :key="index">
                        <a v-on:click="setBaseColor(index)" style="cursor:pointer"><span v-bind:style="{ backgroundColor: '#' + color.code }" class="color-patch-with-label"></span>{{color.name}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <h4>Background Color</h4>
        <div>
            <button
                v-for="(code, index) in colors.suggested" :key="index"
                v-on:click="setBackgroundColor(index)"
                v-bind:class="[colors.selected.backgroundColorCodeIndex === index ? 'active' : '']"
                type="button" class="btn btn-default">
                <span v-bind:style="{ backgroundColor: code }" class="color-patch"></span>
            </button>
        </div>
        <h4>Text Color</h4>
        <div>
            <button
                v-for="(code, index) in colors.suggested" :key="index"
                v-on:click="colors.selected.textColorCodeIndex = index"
                v-bind:class="[colors.selected.textColorCodeIndex === index ? 'active' : '']"
                type="button" class="btn btn-default">
                <span v-bind:style="{ backgroundColor: code }" class="color-patch"></span>
            </button>
        </div>
        <button class="btn btn-success" style="margin-top:20px" @click="save">Save</button>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import CategoryList from '../widgets/category-list'
    import RandomWidget from '../widgets/random-widget'
    import BaseColors from '../utils/base-colors'

    export default {
        data() {
            let suggestedColorCodes = this.getSuggestedColorCodes(BaseColors[0]);
            return {
                widgets: [CategoryList, RandomWidget, RandomWidget, RandomWidget, RandomWidget],
                colors: {
                    base: BaseColors,
                    suggested: suggestedColorCodes,
                    selected: {
                        base: BaseColors[0],
                        backgroundColorCodeIndex: 0,
                        textColorCodeIndex: 0,
                    }
                }
            }
        },
        methods: {
            setBaseColor(index) {
                this.colors.selected.base = BaseColors[index];
                this.colors.suggested = this.getSuggestedColorCodes(BaseColors[index]);
            },
            setBackgroundColor(index) {
                this.colors.selected.backgroundColorCodeIndex = index
                this.$store.dispatch('setBackgroundColorCode', this.colors.suggested[index]);
            },
            getSuggestedColorCodes(baseColor) {
                return _.concat(
                    Please.make_scheme(Please.NAME_to_HSV(baseColor.name), { scheme_type: 'monochromatic' }),
                    Please.make_scheme(Please.NAME_to_HSV(baseColor.name), { scheme_type: 'complementary' }),
                    Please.make_scheme(Please.NAME_to_HSV(baseColor.name), { scheme_type: 'split-complementary' }),
                    Please.make_scheme(Please.NAME_to_HSV(baseColor.name), { scheme_type: 'double-complementary' }),
                    Please.make_scheme(Please.NAME_to_HSV(baseColor.name), { scheme_type: 'analogous' }),
                    Please.make_scheme(Please.NAME_to_HSV(baseColor.name), { scheme_type: 'triadic' }),
                    Please.make_color({colors_returned: 5}),
                );
            },
            save() {
                axios.post('/save', { contents: this.$store.state.contents.map(widget => { return { name: widget.name, template: widget.template } }) })
                             .then((response) => { console.log('template updated successfully!'); })
                             .catch((error) => { console.log(error); });
            }
        },
        components: {
            draggable
        }
    }
</script>

<style lang="scss">
    .drag {
        text-align: center;
    }
    .widget {
        padding: 3px;
        width: 80%;
        border: 1px solid #ccc;
        display: inline-block;
        margin-bottom: 5px;
        margin-top: 5px;
        background-color: #fff;
        cursor: move;
    }
    .color-patch {
        padding: 0 8px;
    }
    .color-patch-with-label {
        padding: 0 8px;
        margin: 0 5px 0 0;
    }
</style>
