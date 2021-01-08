import Cookies from 'js-cookie';
import { getCategoriesList } from '~/api/categories/category'

const state = {
	/*categories: [ 
      { id:0, title: '', url:''} 
    ],*/
    categories: null,
}

const mutations = {
	FETCH_CATEGORIES: ( state, categoriesList ) => {
		state.categories = categoriesList;
	},
	SET_CATEGORIES:( state, categoriesList ) => {		
		state.categories = categoriesList;
	}
};

const getters = {
	getCategories(state){
		return state.categories;
	}
}

const actions = {
	async fetchCategories( context ){
		try{
			const  list  =  await getCategoriesList();                        
        	console.log(list);
			context.commit('FETCH_CATEGORIES', Object.freeze(list.data));
		}catch(e){
			console.log(e);
		}
	},
	setCategories({ commit }, payload){
		commit('SET_CATEGORIES', payload);
	}
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};