<template>
  <div class="amount">
    <img class="amount__image" src="/icons/gold.svg" /> <div class="amount__value">{{ formattedValue }}</div>
  </div>
</template>

<script>
  export default
  {
    props: {
      value: Number,
    },

    computed: {
      formattedValue() {
        return new Intl.NumberFormat().format(this.value)
      }
    }
  }
</script>
