function initialState() {
    return {
        rules: null,
    }
}

const getters = {
    rules: state => state.rules,
}

const actions = {
    sendForm({commit}, payload){
        console.log('sendForm - ', payload);
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setRules(state, rules) {
        state.rules = rules
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
