export default
{
  mode: 'universal',
  /*
  ** Headers of the page
  */
  env: {
    FACEIT_CLIENT_ID: process.env.FACEIT_CLIENT_ID,
  },

  head: {
    titleTemplate: '%s – Skylex.PRO',
    script: [
      { src: 'https://cdn.faceit.com/oauth/faceit-oauth-sdk-1.2.7.min.js' },
    ],
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'icon', type: 'image/png', href: '/favicon/favicon-16x16.png', sizes: '16x16', },
      { rel: 'icon', type: 'image/png', href: '/favicon/favicon-32x32.png', sizes: '32x32', },
      { rel: 'apple-touch-icon-precomposed', sizes: '57x57', href: '/favicon/apple-touch-icon-57x57.png', },
      { rel: 'apple-touch-icon-precomposed', sizes: '72x72', href: '/favicon/apple-touch-icon-72x72.png', },
      { rel: 'apple-touch-icon-precomposed', sizes: '114x114', href: '/favicon/apple-touch-icon-114x114.png', },
      { rel: 'apple-touch-icon-precomposed', sizes: '120x120', href: '/favicon/apple-touch-icon-120x120.png', },
      { rel: 'apple-touch-icon-precomposed', sizes: '144x144', href: '/favicon/apple-touch-icon-144x144.png', },
      { rel: 'apple-touch-icon-precomposed', sizes: '152x152', href: '/favicon/apple-touch-icon-152x152.png', },
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#fff' },
  /*
  ** Global CSS
  */
  css: [
    { lang: 'scss', src: '~/assets/scss/app.scss' }
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    '~/plugins/globalComponents',
  ],
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
    'nuxt-i18n',
    '@nuxtjs/axios',
    '@nuxtjs/auth',
  ],
  bootstrapVue: {
    bootstrapCSS: false, // Or `css: false`
    bootstrapVueCSS: false // Or `bvCSS: false`
  },
  i18n: {
    seo: true,
    lazy: true,
    langDir: 'locales/',
    detectBrowserLanguage: false,

    locales: [
      { code: 'en', iso: 'en-US', file: 'en.js', domain: process.env.DOMAIN_EN, match: '..' },
      { code: 'ru', iso: 'ru-RU', file: 'ru.js', domain: process.env.DOMAIN_RU, match: '^(ru|uk|be)' },
    ],

    differentDomains: true,

    defaultLocale: 'en',
    vueI18n: {
      fallbackLocale: 'en',
      silentTranslationWarn: true,
    },
  },

  auth: {
    cookie: {
      prefix: 'skylex.',
      options: {
        expires: 14,
        domain: process.env.APP_DOMAIN,
      }
    },

    localStorage: {
      prefix: 'skylex.'
    },

    strategies: {
      local: {
        endpoints: {
          logout: { url: process.env.API_URL + 'auth/logout', method: 'post' },
          user: { url: process.env.API_URL + 'auth/me', method: 'get', propertyName: 'user' },
          login: { url: process.env.API_URL + '/auth/login', method: 'post', propertyName: 'token' },
        },
        tokenRequired: true,
        tokenType: 'bearer',
      }
    }
  },
  /*
  ** Axios module configuration
  ** See https://axios.nuxtjs.org/options
  */
  axios: {
  },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend (config, ctx) {
    }
  }
}
