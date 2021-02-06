import Cookies from 'js-cookie';
import Vue from 'vue';
import Vuex from 'vuex'
//import getters from './getters';

/*const state = {
	breadcrumbs: null,
}

const mutations = { 	
	SET_BREADCRUMBS: ( state, href ) =>{
		state.breadcrumbs = href;
	}
};

const getters = {	
	getBreadCrumbs(state){
		return state.breadcrumbs;
	}
}

const actions = {	
	setBreadCrumbs({commit}){
		console.log('setBreadCrumbs');
		let href = window.location.href();
		context.commit('SET_BREADCRUMBS', href);
	}

};*/

Vue.use(Vuex);

const store = new Vuex.Store({
	namespaced: true,
    state: {
    	breadcrumbs: null,
    },
    mutations: {
    	SET_BREADCRUMBS: ( state, href ) =>{
			state.breadcrumbs = href;
		}
    },
    /*getters: {
    	getBreadCrumbs(state){
			return state.breadcrumbs;
		}
    },*/
    actions: {
    	setBreadCrumbs({commit}, value){
			console.log('setBreadCrumbs');			
			commit('SET_BREADCRUMBS', value);
		}
    }
})

export default store;

/*export default {
    namespaced: true,
    state,
    mutations,
    actions,
};*/