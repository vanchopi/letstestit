import Cookies from 'js-cookie';
import { sendForm } from '~/api/form/form'

const state = {	
    result: null,
    request: null,
    pages: null,
    status: null,
}

const mutations = {

}

const getters = {

}

const actions = {
	sendFormData({ commit, state, dispatch }, payload ){
		console.log('sendFormData - ', payload);
		return new Promise((resolve, reject) => {
			sendForm( payload ).then((response) => {
				resolve();
				console.log(response);	
			}).catch((error) => {
				reject();
	            console.log(error)
	        });        	
		});
	},
}

export default {
	namespaced: true,
    state,
    mutations,
    actions,
};