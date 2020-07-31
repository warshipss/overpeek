<template>
  <div class="layout">
    <aside class="sidebar">
      <div :class="['logo', { 'logo_small': isStore }]">
        <img src="/img/logo.png" class="logo__image" />
        <h2 class="logo__text">Overpeek</h2>
      </div>

      <ul class="nav nav_aside">
        <li v-if="isStore">
          <nuxt-link class="nav-link" :to="localePath('index')" key="back">
            &laquo; {{ $t('Go back') }}
          </nuxt-link>
        </li>

        <li class="nav-item" v-for="item of menu" :key="item.path" v-else>
          <nuxt-link :class="['nav-link', { active: $route.path === '/' + item.path }]" :to="localePath(item.path)">
            {{ item.title }}
          </nuxt-link>
        </li>

        <li class="nav-item nav-item_user">
          <nuxt-link :to="profileLink($auth.user.uid)" class="nav-link" @click.prevent>
            <div class="user">
              <img class="user__avatar" :src="$auth.user.avatar" />
              <div class="user__meta">
                <div class="user__nickname">{{ $auth.user.nickname }}</div>
                <amount :value="$auth.user.gold" />
              </div>
            </div>
          </nuxt-link>
        </li>
      </ul>
    </aside>

    <main class="layout__main">
      <nuxt />

      <footer class="footer">
        <div class="footer__bottom">

        </div>
      </footer>
    </main>
  </div>
</template>

<script>
  import GlobalMixin from '../plugins/mixin'

  export default
  {
    middleware: 'auth',
    mixins: [GlobalMixin],

    data() {
      return {
        menu: [
          {
            path: 'play',
            title: this.$t('Play'),
          },
          {
            path: 'deposit',
            title: this.$t('Deposit'),
          },
          {
            path: 'store',
            title: this.$t('Store'),
          },
        ],
      }
    },

    computed: {
      isStore() {
        return this.$route.path === '/store'
      }
    }
  }
</script>
