import Vue from 'vue'
import Vuex from 'vuex'

import TopContent from '../widgets/top-content'
import BottomContent from '../widgets/bottom-content'

Vue.use(Vuex)

const state = {
  count: 0,
  contents: [TopContent, BottomContent]
}

const getters = {
    evenOrOdd: state => state.count % 2 === 0 ? 'even' : 'odd',
    getWidgets: state => {
        state.contents.forEach((widget, index) => {
            if (_.isUndefined(widget.html)) {
                axios.get('/widgets/' + widget.template)
                    .then((response) => {
                        widget.html = response.data;
                        state.contents.splice(index, 1, widget);
                    })
                    .catch((error) => { console.log(error); });
            }
        });
        return state.contents;
    }
}

const actions = {
    increment: ({ commit }) => commit('increment'),
    decrement: ({ commit }) => commit('decrement'),
    addWidget: ({ commit }, widget) => {
        return axios.get('/widgets/' + widget.template)
            .then((response) => {
                widget.html = response.data;
                commit('addWidget', widget);
            })
            .catch((error) => { console.log(error); });
    }
}

const mutations = {
  increment (state) {
    state.count++
  },
  decrement (state) {
    state.count--
  },
  addWidget (state, widget) {
    state.contents.push(widget);
  }
}

export default new Vuex.Store({
  state,
  getters,
  actions,
  mutations
})
