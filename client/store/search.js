import Cookies from 'js-cookie';
import { search } from '~/api/search/search'

const state = {	
    result: null,
    request: null,
}

const mutations = {
	FETCH_RESULT: ( state, requestResult ) => {
		state.result = requestResult;
	},
	CLEAR_SEARCH_RESULTS: (state) => {
		state.result = null;
	},
	/*SET_REQUEST:( state, categoriesList ) => {		
		state.categories = categoriesList;
	}*/
};

const getters = {
	getCategories(state){
		return state.categories;
	},
	getSearchResult(state){
		return state.result;
	}
}

const actions = {
	async fetchSearchResult( context, {str} ){		
		try{
			const  list  =  await search(str);
        	console.log(list);
			context.commit('FETCH_RESULT', list.data);
		}catch(e){
			console.log(e);
		}
	},
	clearSearchResults({commit}){
		commit('CLEAR_SEARCH_RESULTS');
	},
	/*setRequest({ commit }, payload){
		commit('SET_REQUEST', payload);
	}*/
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};