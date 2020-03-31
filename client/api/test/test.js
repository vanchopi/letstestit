import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;
axios.defaults.withCredentials = true;

export function getTest(query){
	console.log('api', process.env);
	return axios({
		
		withCredentials: false,
		method: 'get',
		url: '/test/' + query.id,
		  /*data: {
		    firstName: 'Fred',
		    lastName: 'Flintstone'
		}*/
	  
	});
	
}