function initialState() {
    return {
        item: {
            id: null,
            category: null,
            title: null,
            main_image: null,
            bg_image: null,
            questions: [],
            type: null,
        },
        resultsItem:[],
        categoriesAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    resultsItem: state => state.resultsItem,
    loading: state => state.loading,
    categoriesAll: state => state.categoriesAll,
    
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            console.log('item' , state.item);

            /* filds from item state*/
            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }
            if (_.isEmpty(state.item.questions)) {
                params.set('questions', '')
            } else {
                params.set('questions', JSON.stringify(state.item.questions))
            }            
            if (state.item.main_image === null) {
                params.delete('main_image');
            }
            if (state.item.bg_image === null) {
                params.delete('bg_image');
            }
            
            for (var i = 0; i < state.resultsItem.length; i++) {     
                var myItemInArr = state.resultsItem[i];     
                for (var prop in myItemInArr) {         
                    params.append(`variants[${i}][${prop}]`, myItemInArr[prop]);     
                } 
            }

            /*console.log('params main_image - ', params.get('main_image'));*/
            console.log('params', params.getAll('questions'));

            axios.post('/api/v1/tests', params)
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
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }
            if (state.item.main_image === null) {
                params.delete('main_image');
            }
            if (state.item.bg_image === null) {
                params.delete('bg_image');
            }

            axios.post('/api/v1/tests/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
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
        })
    },
    fetchData({ commit, dispatch }, id) {
        axios.get('/api/v1/tests/' + id)
            .then(response => {                
                commit('setItem', response.data.data)
            })

        dispatch('fetchCategoriesAll')
    },
    fetchCategoriesAll({ commit }) {
        axios.get('/api/v1/categories')
            .then(response => {
                commit('setCategoriesAll', response.data.data)
            })
    },
    setCategory({ commit }, value) {
        commit('setCategory', value)
    },
    setTitle({ commit }, value) {
        commit('setTitle', value)
    },
    setType({ commit }, value) {
        commit('setType', value)
    },
    setMain_image({ commit }, value) {
        commit('setMain_image', value)
    },

    setResultsImage({ commit }, payload) {
        //console.log('value - ', payload.img, ' id - ', payload.id);
        commit('setResultsImage', payload);
    },
    
    setBg_image({ commit }, value) {
        commit('setBg_image', value)
    },

    setQuestions({ commit }, value) {
        commit('setQuestions', value)
    },

    setResults({ commit }, value) {
        commit('setResults', value)
    },
    
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setCategory(state, value) {
        state.item.category = value
    },
    setTitle(state, value) {
        state.item.title = value
    },
    setType(state, value) {
        state.item.type = value
    },
    setMain_image(state, value) {
        state.item.main_image = value;
        console.log(' main image - ', state.item.main_image);
    },
    setResultsImage(state, payload){        
        console.log('1.mutation results - ', state.resultsItem);
        state.resultsItem[payload.id].img = payload.img;
        console.log('2.mutation results - ', state.resultsItem);
    },
    setBg_image(state, value) {
        state.item.bg_image = value
    },
    setQuestions(state, value) {
        state.item.questions = JSON.parse(JSON.stringify(value))
    },
    setResults(state, value) {
        state.resultsItem = JSON.parse(JSON.stringify(value))
    },
    setCategoriesAll(state, value) {
        state.categoriesAll = value
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
