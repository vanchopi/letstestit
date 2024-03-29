require('dotenv').config()
const { join } = require('path')
const path = require('path')
const { copySync, removeSync} = require('fs-extra')
const fs = require('fs')

const config = { 

  srcDir: __dirname,

  env: {
    //apiUrl: process.env.API_URL || process.env.APP_URL + '/api',
    apiUrl: process.env.API_URL + '/api' || process.env.APP_URL + '/api',
    appRoot: process.env.CLIENT_URL || process.env.APP_URL,
    appName: process.env.APP_NAME || 'letstestit',
    appLocale: process.env.APP_LOCALE || 'ru',
    githubAuth: !!process.env.GITHUB_CLIENT_ID,
    mail: process.env.MAIL_MAIN_HOST,
    recaptcha: process.env.RECAPTCHA_ID || ''
  },

  head: {
    title: process.env.APP_NAME,
    titleTemplate: '%s',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { name: 'yandex-verification', content: process.env.YANDEX_ID },
      { name: 'verify-admitad', content: process.env.ADMITAD_ID },
      { name: 'Content-Security-Policy', content: 'upgrade-insecure-requests' },
      { hid: 'description', name: 'description', content: '' },
      { hid: 'keywords', name: 'keywords' , content: ''},
      { hid: 'og:image', property: 'og:image', content: process.env.APP_IMG || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  loading: { color: '#007bff' },

  router: {
    middleware: ['locale', 'check-auth']
  },

  css: [
    { src: '~assets/sass/app.scss', lang: 'scss' }
  ],

  plugins: [
    '~components/global',
    '~plugins/i18n',
    '~plugins/vform',
    '~plugins/axios',
    '~plugins/fontawesome',
    '~plugins/vuelidate',
    //'~plugins/nuxt-client-init', // Comment this for SSR
    { src: '~plugins/bootstrap', mode: 'client' }
  ],

  modules: [
    '@nuxtjs/router',
    '@nuxtjs/google-analytics',
    '@nuxtjs/recaptcha',
    '@nuxtjs/yandex-metrika',
  ],

  recaptcha: {
    hideBadge: true,
    // language: 'en',
    siteKey: process.env.RECAPTCHA_ID,
    version: 3,
    // size: 'invisible'
  },

  googleAnalytics: {
    id: process.env.GOOGLE_ANALYTICS_ID,
    dev: process.env.GOOGLE_ANALYTICS_DEV
  },

  yandexMetrika: {
    id: process.env.YANDEX_METRIKA_ID,
  },

  build: {
    extractCSS: true
  },
  server: {
    port: process.env.SERVER_PORT || 3000, // default: 3000
    // host: '0.0.0.0', // default: localhost,
    // timing: false    
  },
  hooks: {
    generate: {
      done (generator) {
        // Copy dist files to public/_nuxt
        if (generator.nuxt.options.dev === false && generator.nuxt.options.mode === 'spa') {
          const publicDir = join(generator.nuxt.options.rootDir, 'public', '_nuxt')
          removeSync(publicDir)
          copySync(join(generator.nuxt.options.generate.dir, '_nuxt'), publicDir)
          copySync(join(generator.nuxt.options.generate.dir, '200.html'), join(publicDir, 'index.html'))
          removeSync(generator.nuxt.options.generate.dir)
        }
      }
    }
  }
}

if(process.env.APP_STATUS != "dev"){  
  config.server.https = {
      key: fs.readFileSync(path.resolve(process.env.SSL_PATH, 'ssl.letstestit.ru.key')),
      cert: fs.readFileSync(path.resolve(process.env.SSL_PATH, 'ssl.letstestit.ru.crt'))    
  };
}else{
  // config.mode = 'spa'; // Comment this for SSR  
  // config.plugins.push('~plugins/nuxt-client-init'); // Comment this for SSR  
}

module.exports = {
  ...config
}
