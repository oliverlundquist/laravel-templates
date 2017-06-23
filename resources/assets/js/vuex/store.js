import Vue from 'vue'
import Vuex from 'vuex'

import TopContent from '../widgets/top-content'
import BottomContent from '../widgets/bottom-content'

Vue.use(Vuex)

const state = {
  backgroundColorCode: "#FFF",
  contents: [TopContent, BottomContent]
}

const getters = {
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
    addWidget: ({ commit }, payload) => {
        return axios.get('/widgets/' + payload.element.template)
            .then((response) => {
                payload.element.html = response.data;
                commit('addWidget', payload);
            })
            .catch((error) => { console.log(error); });
    },
    setBackgroundColorCode: ({ commit }, payload) => {
        commit('setBackgroundColorCode', payload);
    }
}

const mutations = {
    addWidget (state, payload) {
        state.contents.splice(payload.index, 0, payload.element);
    },
    setBackgroundColorCode(state, payload) {
        state.backgroundColorCode = payload;
    }
}

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
})
