import Vue from 'vue'
import Router from 'vue-router'
import { scrollBehavior } from '~/utils'
import store from '~/store/breadcrumbs.js'

Vue.use(Router)

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m)

const routes = [
  { 
    path: '/', 
    name: 'welcome', 
    component: page('welcome.vue') 
  },

  { 
    path: '/catalog', 
    name: 'catalog',
    //title: this.$t('catalog'), 
    component: page('catalog.vue') 
  },
  { 
    path: '/catalog/:url', 
    name: 'category', 
    component: page('category.vue'),
    /*props: { id: null } */
  },
  { 
    path: '/catalog/:url1/:url2', 
    name: 'test', 
    component: page('test.vue'),
    /*children: [{
        path: '', 
        name: 'results', 
        component: page('results.vue') 
    }]*/
  },
  /*{ 
    //path: '/test/:id/results/',
    path: '/catalog/:url1/:url2/result',
    name: 'results', 
    component: page('results.vue') 
  },*/

  { 
    path: '/search/:search', 
    name: 'search', 
    component: page('search.vue') 
  },
  /* *****-------------------------------------------***** */
  /*{ 
    path: '/login', 
    name: 'login', 
    component: page('auth/login.vue') 
  },
  { 
    path: '/register', 
    name: 'register', 
    component: page('auth/register.vue') 
  },
  { 
    path: '/password/reset', 
    name: 'password.request', 
    component: page('auth/password/email.vue') 
  },
  { 
    path: '/password/reset/:token', 
    name: 'password.reset', 
    component: page('auth/password/reset.vue') 
  },
  { 
    path: '/email/verify/:id', 
    name: 'verification.verify', 
    component: page('auth/verification/verify.vue') 
  },
  { 
    path: '/email/resend', 
    name: 'verification.resend', 
    component: page('auth/verification/resend.vue') 
  },

  { 
    path: '/home', 
    name: 'home', 
    component: page('home.vue') 
  },
  { 
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] 
  }*/
];

const router = new Router({
    routes,
    scrollBehavior,
    mode: 'history'
})

router.beforeEach((to, from, next) => {
    console.log('beforeEach');
    next();
});

router.afterEach((to, from) => {
  /*console.log(' href - ', router.app.path);
  store.dispatch("setBreadCrumbs", window.location.href);*/
  //console.log(' store - ', store);
});

/*export function createRouter () {
  return new Router({
    routes,
    scrollBehavior,
    mode: 'history'
  })
}*/

//export default router;

export function createRouter () {
  return router
}
