function initialState() {
    return {
        rules: null,
        loading: false,
    }
}

const getters = {
    rules: state => state.rules,
}

const actions = {
    sendForm({commit, dispatch}, payload){
        console.log('sendForm - ', payload);
        return new Promise((resolve, reject) => {
            let params = new FormData();
            for( let prop in payload){
                params.set(prop, payload[prop]);
            }
            // console.log(params);
            axios.post('/api/v1/affilates', params)
                .then(response => {
                    commit('resetState')
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        });
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setRules(state, rules) {
        state.rules = rules
    },
    setLoading(state, loading) {
        state.loading = loading
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
