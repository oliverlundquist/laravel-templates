<template>
    <div class="dragger">
        <div class="preview-modal" v-if="showModal">
            <div class="preview-modal-inner">
                <div class="modal-menu">
                    <div class="btn" @click="frame = { width: 1024, height: 768 }"><span class="glyphicon glyphicon-phone"></span>Desktop</div>
                    <div class="btn" @click="frame = { width: 768, height: 1024 }"><span class="glyphicon glyphicon-phone"></span>iPad</div>
                    <div class="btn" @click="frame = { width: 375, height: 667 }"><span class="glyphicon glyphicon-phone"></span>iPhone</div>
                    <div class="btn" @click="frame = { width: 380, height: 667 }"><span class="glyphicon glyphicon-qrcode"></span>QR</div>
                </div>
                <div class="qr-code-view" v-if="frame.width === 380">
                    <h3>Scan this QR code</h3>
                    <h4>to preview the template on your smartphone or tablet</h4>
                    <div v-html="getQRCode()"></div>
                </div>
                <iframe v-else class="frame" v-bind:style="{ width: frame.width + 'px', height: frame.height + 'px' }" v-bind:src="template_id"></iframe>
            </div>
        </div>
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
        <div>
            <button class="btn btn-default" style="margin-top:20px;" @click="showModal = !showModal">Preview</button>
        </div>
        <div>
            <button class="btn btn-success" style="margin-top:10px;" @click="save">Save</button>
        </div>
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
                },
                showModal: false,
                frame: { width: 1024, height: 768 }
            }
        },
        computed: {
            template_id() {
                console.log('getting template_id');
                return 'http://localhost/?preview_template_id=' + window.template_id;
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
                             .then((response) => { console.log('template updated successfully!'); window.location.href = "/templates"; })
                             .catch((error) => { console.log(error); });
            },
            getQRCode() {
                var typeNumber = 8;
                var errorCorrectionLevel = 'L';
                var qr = qrcode(typeNumber, errorCorrectionLevel);
                qr.addData('http://10.0.0.160/?preview_template_id=' + template_id);
                qr.make();
                return qr.createImgTag();
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
    .preview-modal {
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        padding:20px;
        background-color:rgba(0,0,0,0.5);
        z-index:100;
        text-align:center;
    }
    .preview-modal-inner {
        display:inline-block;
    }
    .modal-menu {
        width:355px;
        display:inline-block;
        background-color:#fff;
        padding:5px 5px 5px 14px;
        text-align:left;
    }
    .qr-code-view {
        padding:20px;
        background-color:#fff;
        text-align:center;
    }
    iframe {
        border:none;
        display:block;
    }
    .glyphicon {
        padding-right:3px;
    }
</style>
