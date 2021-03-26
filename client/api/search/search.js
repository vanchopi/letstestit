import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function search(str, page){		
	return axios({				
		method: 'post',
		url: '/search?page=' + page,
		  data: {
		    search: str,
		}	  
	});	
}