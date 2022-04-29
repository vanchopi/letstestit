import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function search(str, token, page){		
	return axios({				
		method: 'post',
		url: '/search?page=' + page,
		  data: {
		    search: str,
		    token: token,
		}	  
	});	
}