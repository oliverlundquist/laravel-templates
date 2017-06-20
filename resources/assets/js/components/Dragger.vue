<template>
    <div class="dragger">
        <h1>Toolbox</h1>
        <div class="drag">
            <h2>Tools</h2>
            <draggable v-model="list" class="dragArea" :options="{group:{ name:'people',  pull:'clone', put:false }}">
                <div v-for="(element, index) in list" :key="index">{{element.name}}</div>
            </draggable>
        </div>

        <div class="normal">
            <h2>Static</h2>
            <div class="dragArea">
                <div v-for="element in list">{{element.name}}</div>
            </div>
        </div>

        <button @click="add">Add</button>
        <button @click="replace">Replace</button>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    let somewidget = '';
    somewidget += '<div class="row">'
    somewidget += '                  <div class="col-md-3 col-sm-6 col-xs-6 grid_image">';
    somewidget += '                      <a href="http://webshipr2.mystore4.no/categories/dame" class="banner_image animation-none" style="background-image: url(http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f3295f58.jpg);">';
    somewidget += '                        <img src="http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f3295f58.jpg">';
    somewidget += '                                            <p id="banner_one_four_one_text" class="banner_one_four_text text-left"></p>';
    somewidget += '                      </a>';
    somewidget += '                  </div>';
    somewidget += '                                              <div class="col-md-3 col-sm-6 col-xs-6 grid_image">';
    somewidget += '                      <a href="http://webshipr2.mystore4.no/categories/herre" class="banner_image animation-none" style="background-image: url(http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f32a57f6.jpg);">';
    somewidget += '                        <img src="http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f32a57f6.jpg">';
    somewidget += '                                            <p id="banner_one_four_two_text" class="banner_one_four_text text-left"></p>';
    somewidget += '                      </a>';
    somewidget += '                  </div>';
    somewidget += '                                              <div class="col-md-3 col-sm-6 col-xs-6 grid_image">';
    somewidget += '                      <a href="http://webshipr2.mystore4.no/categories/sko" class="banner_image animation-none" style="background-image: url(http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f32b25d4.jpg);">';
    somewidget += '                        <img src="http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f32b25d4.jpg">';
    somewidget += '                                            <p id="banner_one_four_three_text" class="banner_one_four_text text-left"></p>';
    somewidget += '                      </a>';
    somewidget += '                  </div>';
    somewidget += '                                              <div class="col-md-3 col-sm-6 col-xs-6 grid_image">';
    somewidget += '                      <a href="http://webshipr2.mystore4.no/categories/dame" class="banner_image animation-none" style="background-image: url(http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f32c12c0.jpg);">';
    somewidget += '                        <img src="http://webshipr2.mystore4.no/users/demomal_mystore_no/images/upload_148958392258c93f32c12c0.jpg">';
    somewidget += '                                            <p id="banner_one_four_four_text" class="banner_one_four_text text-left"></p>';
    somewidget += '                      </a>';
    somewidget += '                  </div>';
    somewidget += '</div>';

    export default {
        data() {
            return {
                list: [
                    { name:"John", "widget": '{{ something1 }}'},
                    { name:"Joao", "widget": '<h1>big title</h1>'},
                    { name:"Jean", "widget": somewidget}
                ]
            }
        },
        methods: {
            add() { this.list.push({name:'Juan'}); },
            replace() { this.list = [{name:'Edgard'}] },
            getSomething() {
                //console.log(this.$http);
            }
        },
        mounted() {
            console.log('Draggable mounted.');
            this.getSomething();
        },
        components: {
            draggable
        }
    }
</script>

<style lang="scss">
    .dragger {
        background-color:#ddd;
    }
</style>
