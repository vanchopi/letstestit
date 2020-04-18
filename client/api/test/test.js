import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function getTest(query){	
	return axios({				
		method: 'get',
		url: '/test/' + query//.id,
		  /*data: {
		    firstName: 'Fred',
		    lastName: 'Flintstone'
		}*/	  
	});	
}

export function getTestsList( curCat ){	
	return axios({				
		method: 'post',
		url: '/tests/getlist',
		  data: {
		    category: curCat
		}	  
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

export function getTestResults( id, answers ){
	return axios({				
		method: 'post',
		url: '/tests/getresults',
		  data: {
		    id: id,
		    answers: answers
		}	  
	});		
}