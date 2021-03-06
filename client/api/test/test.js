import axios from 'axios'
axios.defaults.baseURL = process.env.APP_URL;

export function getTest(query){	
	return axios({				
		method: 'get',
		url: '/test/' + query//.id,
		  /*data: {
		    id: '',
		}*/	  
	});	
}

export function getTestsList( curCat, url = false ){
	return axios({				
		method: 'post',
		url: '/tests/getlist',
		  data: {
		    category: curCat,
		    url: url,
		}	  
	});	
}

export function getMoreTests( num, cat, url = false, id = null ){
	return axios({				
		method: 'post',
		url: '/tests/getmore',
		  data: {
		    step: num,
		    category: cat,
		    url: url,
		    id: id,
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

export function getMeta( id ){
	return axios({				
		method: 'post',
		url: '/test/getmeta',
		  data: {
		    id: id,
		}	  
	});		
}

export function getTopList(){
	return axios({				
		method: 'post',
		url: '/test/gettoplist',
	});		
}