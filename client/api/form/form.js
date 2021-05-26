import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function sendForm(query){
	console.log('data - ', query);	
	return axios({				
		method: 'post',
		url: '/form/send',
		data:  query,		
	});	
}