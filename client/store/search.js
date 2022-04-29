import Cookies from 'js-cookie';
import { search } from '~/api/search/search'

const state = {	
    result: null,
    request: null,
    pages: null,
}

const mutations = {
	FETCH_RESULT: ( state, requestResult ) => {
		state.result = requestResult;
		state.pages = {
			from: requestResult.from,
			to: requestResult.to,
			total: requestResult.total, 
		}
	},
	FETCH_MORE_RESULT: ( state, requestResult ) => {
		
		for(let i = 0; i < requestResult.data.length; i++){
			state.result.data.push(requestResult.data[i]);
		}
		/*state.result.from = requestResult.from;
		state.result.to = requestResult.to;
		state.result.total = requestResult.total;*/
		state.pages = {
			from: requestResult.from,
			to: requestResult.to,
			total: requestResult.total, 
		}
		console.log('result - ', state.result);
	},
	CLEAR_SEARCH_RESULTS: (state) => {
		state.result = null;
	},
	SET_REQUEST:( state, value ) => {		
		state.request = value;
	},
	CLEAR_REQUEST: (state) => {
		state.request = null;
	},
};

const getters = {
	getCategories(state){
		return state.categories;
	},
	getSearchResult(state){
		return state.result;
	},
	getRequest(state){
		return state.request;
	}
}

const actions = {
	async fetchSearchResult( context, {str, token, page = 1} ){
		console.log('fetchSearchResult');
		try{
			const  list  =  await search(str, token, page);
        	//console.log(list);
			context.commit('FETCH_RESULT', list.data);
		}catch(e){
			console.log(e);
		}
	},
	async moreSearchResult(context, {str, token, page} ){
		try{
			const  list  =  await search(str, token,  page);
        	//console.log(list);
			context.commit('FETCH_MORE_RESULT', list.data);
		}catch(e){
			console.log(e);
		}	
	},
	clearSearchResults({commit}){
		commit('CLEAR_SEARCH_RESULTS');
	},
	setRequest({ commit }, value){
		commit('SET_REQUEST', value);
	},
	clearRequest({commit}){
		commit('CLEAR_REQUEST');
	}
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};