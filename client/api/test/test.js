import axios from 'axios'
axios.defaults.baseURL = process.env.apiUrl

export function getTest(query){

    return axios.get('/test', {
	    params: query
	});
	
}