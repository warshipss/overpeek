<template>
  <div class="layout__content">
    <div class="jumbotron jumbotron_csgo">
      <div class="jumbotron__inner">
        <!--        <p class="lead">-->
        <!--          Info text-->
        <!--        </p>-->

        <h1 class="jumbotron__heading">{{ $t('Authorizing') }}...</h1>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'landing',

  title() {
    return {
      title: this.$t('Authorizing'),
    }
  },

  async mounted() {
    const { data } = await this.$axios.get('/auth/faceit', {
      params: this.$route.query,
    })

    this.$auth.setToken('local', 'Bearer ' + data.token)

    this.$auth.fetchUser().then(() => {
      this.$router.push(this.localePath('play'))
    })
  },
}
</script>
