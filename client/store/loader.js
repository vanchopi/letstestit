import Cookies from 'js-cookie';
import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);
//init store
const loader = new Vuex.Store({
    state: {        
        ifLoading: true,
        txt: '',
    },
    /*getters: {
        getIfLoader(state){
            return state.ifLoading;
        },
    },*/
    mutations: {        
        CHANGE_LOADING(state, value){
            state.ifLoading = value;
        },
        CHANGE_TXT_LOADING(state, value){
            state.txt = value;
        }
    },
    actions: {
        changeLoading({commit}, value){
            //console.log('loader state');
            commit('CHANGE_LOADING', value);
        },
        chageTxtLoading({commit}, value){
            commit('CHANGE_TXT_LOADING', value);
        }
    }
})

export default loader