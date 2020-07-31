import Vue from 'vue'

export default Vue.mixin({
  methods: {
    profileLink (id) {
      return this.localePath({
        name: 'profile-id',
        params: { id },
      })
    }
  }
})
