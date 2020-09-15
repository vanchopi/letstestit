import Cookies from 'js-cookie';
import { getTestResults } from '~/api/test/test'

const state = {
	results: {
		img: '1.jpg',
		title: 'О_о?',
		description: '',
		id: '',
		media: 'https://letstestit.ru/images/2.jpg',
		quote: 'Тестовая цитата',
		url: 'https://letstestit.ru',
		hashtags:'letstestit',
	}
}

const mutations = {
	SET_TEST_RESULTS: ( state, testResults ) => {
		state.results = testResults;
	}
};

const getters = {
	getTestResults(state){
		return state.results;
	}
}

const actions = {
	async setTestResults( context, { id, answers } ){
		try{
			const  list  =  await getTestResults( id, answers );
        	console.log(list);
			context.commit('SET_TEST_RESULTS', Object.freeze(list.data));
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