import Cookies from 'js-cookie';
import { getCategoriesList } from '~/api/categories/category'

const state = {
	categories: [ 
      { id:0, txt: ''} 
    ],
}

const mutations = {
	FETCH_CATEGORIES: ( state, categoriesList ) => {
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
			context.commit('FETCH_CATEGORIES', Object.freeze(list.data[0]));
		}catch(e){
			console.log(e);
		}
	}
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};