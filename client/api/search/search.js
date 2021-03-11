import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function search(str){	
	return axios({				
		method: 'post',
		url: '/search',
		  data: {
		    search: str,
		}	  
	});	
}