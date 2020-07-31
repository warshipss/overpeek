<template>
  <div class="layout__content">
    <div class="jumbotron jumbotron_deposit">
      <div class="jumbotron__inner">
        <!--        <p class="lead">-->
        <!--          Info text-->
        <!--        </p>-->

        <h1 class="jumbotron__heading"><img src="/icons/gold.svg" :width="32" /> 100 &equals; {{ rate }} ₽</h1>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: this.$t('Deposit'),
    }
  },

  data() {
    return {
      rate: 78,
    }
  }
}
</script>
