import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function getTest(query){	
	return axios({				
		method: 'get',
		url: '/test/' + query.id,
		  /*data: {
		    firstName: 'Fred',
		    lastName: 'Flintstone'
		}*/	  
	});	
}

export function getTestsList(){	
	return axios({				
		method: 'get',
		url: '/tests/getlist',
		  /*data: {
		    firstName: 'Fred',
		    lastName: 'Flintstone'
		}*/	  
	});	
}

export function getMoreTests( num, cat ){
	return axios({				
		method: 'post',
		url: '/tests/getmore',
		  data: {
		    step: num,
		    category: cat
		}	  
	});		
}