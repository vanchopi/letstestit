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
	/*SET_REQUEST:( state, categoriesList ) => {		
		state.categories = categoriesList;
	}*/
};

const getters = {
	getCategories(state){
		return state.categories;
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