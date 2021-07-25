function initialState() {
    return {
        item: null,        
    }
}

const getters = {
    item: state => state.item,    
}

const actions = {
    setEditorItem({ commit }, value) {
        commit('setItem', value)
    },    
}

const mutations = {
    setItem(state, value) {
        state.item = value
    },    
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
