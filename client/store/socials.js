const state = {	
    socials: {
    	vk: 'https://vk.com/lets_test_it',
	    fb: 'https://www.facebook.com/groups/theletstestit',
	    twitter: 'https://twitter.com/_Lets_Test_It_',
	    inst: 'https://www.instagram.com/_lets_test_it_/',
    }
}

const mutations = {
}

const getters = {
	getSocials(){
		return state.socials;
	}
}

const actions = {	
}

export default {
	namespaced: true,
    state,
    mutations,
    actions,
};