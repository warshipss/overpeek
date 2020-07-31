<template>
  <div class="landing">
    <div class="container">
      <div class="jumbotron__inner">
        <p>Tired of playing for fun? Tired of unskilled teammates? We'll bring sense to your games.</p>
        <h1 class="jumbotron__heading">Play FaceIT for skins</h1>
      </div>

      <hr class="my-4">

      <div class="login-area">
        <a href="#" class="btn btn-primary" @click.prevent="login">Log In to start playing</a>
      </div>

      <div class="row">
        <div class="benefit">
          <img src="/img/landing/ac.svg" class="benefit__image" />
          <h3 class="benefit__title">{{ $t('FaceIT anticheat required') }}</h3>
          <p class="benefit__details">Best anti-cheat software guarantees <br />your enemy won't cheat.</p>
        </div>

        <div class="benefit">
          <img src="/img/landing/knife.png" class="benefit__image" />
          <h3 class="benefit__title">{{ $t('Best skins for the prize') }}</h3>
          <p class="benefit__details">
            {{ $t('Our partners handpicked best skins for you') }}
          </p>
        </div>

        <div class="benefit">
          <img src="https://image.flaticon.com/icons/svg/1208/1208198.svg" class="benefit__image" />
          <h3 class="benefit__title">{{ $t('Balanced games') }}</h3>
          <p class="benefit__details">
            {{ $t('Play versus same skilled players') }} <br />
            {{ $t('Or cancel the game without losts') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default
  {
    layout: 'landing',
    middleware: 'guests',

    head() {
      return {
        title: this.$t('Welcome'),
      }
    },

    data() {
      return {
        faceit: null,
      }
    },

    methods: {
      login () {
        // return this.$auth.setToken('local','Bearer vm2paSvbC6z47CroRfQBksRN5J3jm6WXUrHhtZI7icO0Z0Xqkhwevi7KI9sZROdswVesiqk1gcjU4N2z')

        if (! this.faceit)
        {
          this.faceit = true

          window.FACEIT.init({
            debug: true,
            response_type: 'code',
            client_id: process.env.FACEIT_CLIENT_ID,
          })
        }

        window.FACEIT.loginWithFaceit()
      }
    }
  }
</script>
