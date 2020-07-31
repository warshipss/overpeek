<template>
  <div class="layout__content">
    <div class="jumbotron jumbotron_store">
      <div class="jumbotron__inner">
        <p class="lead">{{ $t('We\'ve handpicked best skins for you') }}</p>

        <h1 class="jumbotron__heading">{{ $t('Store') }}</h1>
      </div>
    </div>

    <div class="store">
      <store-item :item="item" v-for="item of items" :key="item.uid" />
    </div>
  </div>
</template>

<script>
  import StoreItem from '~/components/store/item.vue'

  export default {
    components: { StoreItem },

    head() {
      return {
        title: this.$t('Store'),
      }
    },

    async asyncData({ app }) {
      const { data } = await app.$axios.get('/store')

      return {
        items: data.items,
      }
    },

    data() {
      return {
        rate: 78,
      }
    }
  }
</script>
