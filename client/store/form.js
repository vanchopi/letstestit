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
			let data = new FormData();
			data.set('name', payload.name);
			data.set('email', payload.email);
			data.set('message', payload.message);
			sendForm( data ).then((response) => {
				resolve(response);
				console.log(response);	
			}).catch((error) => {
				reject(error);
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