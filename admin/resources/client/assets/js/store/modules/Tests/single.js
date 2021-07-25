function initialState() {
    return {
        item: {
            id: null,
            category: null,
            title: null,
            url: null,
            main_image: null,
            bg_image: null,
            popularity: null,
            questions: [],
            test_type: 'knowledges', 
            seo: null,           
        },
        resultsItem:[],
        categoriesAll: [],
        mediaDump: [],

        loading: false,
    }
}

const helpers = {
    questionsImagesArr: function( arr ){
        let result = [];
        for( let i = 0; i < arr.length; i++){
            if(arr[i].img != null){
                result.push({
                    img: arr[i].img
                });
            }
        };
        console.log('1.2 - image arr - ', result);
        return result;
    },
    recombineQuestions: function( arr ){
        console.log('mass - ', arr);
        var mass = arr.map(a => ({...a}));
        for (let i = 0; i < mass.length; i++){
            mass[i].img = mass[i].img != null ? mass[i].img.name : mass[i].img;
        };
        console.log('6. combine questions - ', JSON.stringify(mass));
        return mass;
    },
}

const getters = {
    item: state => state.item,
    resultsItem: state => state.resultsItem,
    loading: state => state.loading,
    categoriesAll: state => state.categoriesAll,
    mediaDump: state => state.mediaDump,
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
                //console.log('1.1 - fieldName', fieldName);
                if(fieldName != 'questions'){
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
            }
            let questionsImg = helpers.questionsImagesArr(state.item.questions);
            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }
            if (_.isEmpty(state.item.questions)) {
                params.set('questions', '')
            } else {
                params.set('questions', JSON.stringify(helpers.recombineQuestions(state.item.questions)))
            }
            if (_.isEmpty(state.item.seo)) {
                params.set('seo', '')
            } else {
                params.set('seo', JSON.stringify(state.item.seo))
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
                    if (prop != 'resultThumb') {
                        params.append(`variants[${i}][${prop}]`, myItemInArr[prop]);     
                    }else{                        
                        let thumb = myItemInArr[prop]; // .src - ?
                        params.append(`variants[${i}][thumb]`,JSON.stringify(thumb));
                    }
                } 
            } 
            if(questionsImg.length){           
                for (var i = 0; i < questionsImg.length; i++) {
                    params.append(`qestions_img[${i}]`, questionsImg[i].img);
                }
            }else{
                params.set('qestions_img', '');
            }
            //console.log('4. all questions - ', state.item.questions);
            //console.log(' 5. questions img - ', questionsImg);
            /*console.log('params main_image - ', params.get('main_image'));*/
            console.log('! results - ', state.resultsItem);
            //console.log('variants', params.getAll('variants'));
            //console.log('qestions_img - ', params.getAll('qestions_img'));

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
            console.log('0. !!! update - ', state.item);
            console.log('1. !!! update - ', state.resultsItem);
            /* filds from item state*/
            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                //console.log('1.1 - fieldName', fieldName);
                if(fieldName != 'questions'){
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
            }

            let questionsImg = helpers.questionsImagesArr(state.item.questions);
            console.log('questionsImg - ', questionsImg);
            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }
            if (_.isEmpty(state.item.questions)) {
                params.set('questions', '')
            } else {
                params.set('questions', JSON.stringify(helpers.recombineQuestions(state.item.questions)))
            }
            if (_.isEmpty(state.item.seo)) {
                params.set('seo', '')
            } else {
                params.set('seo', JSON.stringify(state.item.seo))
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
                    if (prop != 'resultThumb') {
                        params.append(`variants[${i}][${prop}]`, myItemInArr[prop]);
                        console.log('myItemInArr[prop] - ', myItemInArr[prop]);
                    }else{                        
                        let thumb = myItemInArr[prop]; // .src - ?
                        params.append(`variants[${i}][thumb]`,JSON.stringify(thumb));
                    }
                } 
            } 
            if(questionsImg.length){           
                for (var i = 0; i < questionsImg.length; i++) {
                    params.append(`qestions_img[${i}]`, questionsImg[i].img);
                    console.log('qestions_img[${i}] - ', questionsImg[i].img);
                }
            }else{
                params.set('qestions_img', '');
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
                console.log('test data - ', response.data.tests);                
                //commit('setResultsItem', response.data.results.variants);
                commit('setResultsItem', response.data.results);
                dispatch('setResultsItemImages', response.data.media.results);
                commit('setItem', response.data.tests);
                dispatch('setQuestionItemImages', response.data.media.questions);
                //commit('setFullSeo', response.data.meta.data);
                commit('setFullSeo', response.data.meta);                                
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
    setUrl({ commit }, value) {
        commit('setUrl', value)
    },
    setPopularity({ commit }, value){
        commit('setPopularity', value)  
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

    setSeo({commit}, payload){
        commit('setSeo', payload);
    },
    
    resetState({ commit }) {
        commit('resetState')
    },
    setResultsItemImages({commit}, payload){
        commit('setResultsItemImages', payload);
    },
    setQuestionItemImages({commit, state}, payload){
        commit('setQuestionItemImages', payload);
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setFullSeo(state, item){
        //state.item.seo = Object.assign({}, JSON.parse(item))
        state.item.seo = Object.assign({}, item);
    },
    setResultsItem(state, item) {
        //state.resultsItem = JSON.parse(item)/*Object.assign({}, JSON.parse(item))*/
        state.resultsItem = item
    },
    setResultsItemImages(state, payload){        
        payload.forEach( (el, i) => {
            state.resultsItem[i].img = el
        });
    },
    setQuestionItemImages(state, payload){        
        state.mediaDump = payload;
    },
    setCategory(state, value) {
        state.item.category = value
    },
    setTitle(state, value) {
        state.item.title = value
    },
    setUrl(state, value) {
        state.item.url = value
    },
    setPopularity(state, value) {
        state.item.popularity = value
    },
    setType(state, value) {
        state.item.test_type = value
    },
    setMain_image(state, value) {
        state.item.main_image = value;
        //console.log(' main image - ', state.item.main_image);
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
        //state.item.questions = JSON.parse(JSON.stringify(value));
        state.item.questions = value;
    },
    setSeo(state, payload){
        state.item.seo = JSON.parse(JSON.stringify(payload));
    },
    setResults(state, value) {
        state.resultsItem = value;
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
