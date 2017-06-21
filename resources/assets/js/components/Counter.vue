<template>
  <div>
    Clicked: {{ $store.state.count }} times, count is {{ evenOrOdd }}.
    <button @click="increment">+</button>
    <button @click="decrement">-</button>
    <button @click="somethingElse">somethingelse</button>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  computed: mapGetters([
    'evenOrOdd'
  ]),
  methods: Object.assign({},
    mapActions([
        'increment',
        'decrement'
    ]),
    {
        somethingElse() {
            console.log('yay!!');
        }
    }
  )
}
</script>
