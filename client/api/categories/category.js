import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function getCategoriesList(){	
	return axios({				
		method: 'get',
		url: '/categories/getlist',
		  /*data: {
		    firstName: 'Fred',
		    lastName: 'Flintstone'
		}*/	  
	});	
}

export function getMeta( url ){
	return axios({				
		method: 'post',
		url: '/categories/getmeta',
		  data: {
		    url: url,
		}	  
	});		
}