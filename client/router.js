import Vue from 'vue'
import Router from 'vue-router'
import { scrollBehavior } from '~/utils'
//import store from '~/store/breadcrumbs.js'
import loader from '~/store/loader.js'
import Cookies from 'js-cookie'
import * as langs from '~/store/lang.js'
import { cookieFromRequest } from '~/utils'
import i18n from '~/plugins/i18n'

Vue.use(Router)

/*function getCookieValue(a) {
    var b = document.cookie.match('(^|[^;]+)\\s*' + a + '\\s*=\\s*([^;]+)');
    return b ? b.pop() : '';
};*/ // not for ssr mode

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m);

//let defaultLocale =  != undefined ?  : 'en';
let defaultLocale = langs.state().locale != undefined ? langs.state().locale : 'ru';
console.log('1. opa - ', langs.state().locale/*, langs12 = cookieFromRequest(req, 'locale')*/);
const routes = [
  // 1. main page with language and it redirect 
  { 
    path: '/:locale', 
    name: 'welcome', 
    component: page('welcome.vue') 
  },
  {
    path: "/",
    redirect: `/${defaultLocale}`
  },
  // *** end main page ***

  // 2. catalog page with language and it redirect  
  { 
    path: '/:locale/catalog', 
    name: 'catalog',
    //title: this.$t('catalog'), 
    component: page('catalog.vue') 
  },
  {
    path: "/catalog",
    redirect: `/${defaultLocale}/catalog`
  },
  // *** end catalog page ***

  // 3. category page with language and it redirect  
  { 
    path: '/:locale/catalog/:url', 
    name: 'category', 
    component: page('category.vue'),
    /*props: { id: null } */
  },
  {
    path: "/catalog/:url",
    redirect: `/${defaultLocale}/catalog/:url`
  },
  // *** end category page ***

  // 4. test page with language and it redirect
  { 
    path: '/:locale/catalog/:url1/:url2', 
    name: 'test', 
    component: page('test.vue'),
    /*children: [{
        path: '', 
        name: 'results', 
        component: page('results.vue') 
    }]*/
  },
  {
    path: "/catalog/:url1/:url2",
    redirect: `/${defaultLocale}/catalog/:url1/:url2`
  },
  // *** end test page ***

  /*{ 
    //path: '/test/:id/results/',
    path: '/catalog/:url1/:url2/result',
    name: 'results', 
    component: page('results.vue') 
  },*/

  // 5. search page with language and it redirect
  { 
    path: '/:locale/search', 
    name: 'search', 
    component: page('search.vue') 
  },
  {
    path: "/search",
    redirect: `/${defaultLocale}/search`
  },
  // *** end search page ***

  // 6. about page with language and it redirect
  { 
    path: '/:locale/about', 
    name: 'about', 
    component: page('about.vue') 
  },
  {
    path: "/about",
    redirect: `/${defaultLocale}/about`
  },
  // *** end about page ***
  /*{
    path: "/(.*)",
    redirect: to => {
      return "/" + defaultLocale + to.path;
    }
  }*/
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
    //console.log('beforeEach');    
    //loader.dispatch("changeLoading", true);
    /*let lang = to.params.lang;
    if (!lang) {
      lang = 'ru';
    }
    console.log('lang - ', lang);*/

    // set the current language for vuex-i18n. note that translation data
    // for the language might need to be loaded first
    ///Vue.i18n.set(language);    
    to.params.locale = langs.getters['locale'];
    console.log('to.params.locale - ', to.params.locale);
    //console.log('to.params - ', to, from);
    next(to.params);
});

router.afterEach((to, from) => {
  /*console.log(' href - ', router.app.path);
  store.dispatch("setBreadCrumbs", window.location.href);*/
  //console.log('afterEach');  
  //loader.dispatch("changeLoading", false); 
  //console.log(loader.state.ifLoading);
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
