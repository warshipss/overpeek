<template>
  <div class="layout__content">
    <div class="jumbotron jumbotron_csgo">
      <div class="jumbotron__inner">
<!--        <p class="lead">-->
<!--          Info text-->
<!--        </p>-->

        <h1 class="jumbotron__heading">Play CS:GO</h1>
      </div>
    </div>

    <div class="container-fluid">
      <template v-if="match">
        <h3 class="display-2">{{ $t('Current match') }}</h3>

        <div class="match match_mb3">
          <div class="match__team match__team--first">
            <h2 class="match__team-title">{{ match[0].title }}</h2>
            <img class="match__team-image" :src="match[0].image" />
          </div>

          <div class="match__score">
            <h1>VS</h1>
            <span></span>
          </div>

          <div class="match__team match__team--last">
            <h2 class="match__team-title">{{ match[1].title }}</h2>
            <img class="match__team-image" :src="match[1].image" />
          </div>
        </div>
      </template>

      <template v-if="false">
        <h3 class="display-2">{{ $t('How to play') }}</h3>
        <div class="row">
          <div class="col-xs-12 col-md-3">
            <div class="card">
              123
            </div>
          </div>
          <div class="col-xs-12 col-md-3"></div>
          <div class="col-xs-12 col-md-3"></div>
          <div class="col-xs-12 col-md-3"></div>

        </div>
        <ol>
          <li>{{ $t('Deposit money to your account') }}</li>
          <li>{{ $t('Select hub with needed parameters') }}</li>
          <li>{{ $t('Join the hub and start the queue') }}</li>
          <li>{{ $t('Make sure your match is displayed at the website') }}</li>
        </ol>
      </template>

      <h3 class="display-2">{{ $t('Hub list') }}</h3>

      <table class="table table_hubs">
        <thead>
        <tr>
          <th></th>
          <th>{{ $t('Title') }}</th>
          <th>{{ $t('Bet') }}</th>
          <th>{{ $t('Type') }}</th>
          <th>{{ $t('Players') }}</th>
          <th></th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="hub of hubs">
          <td>
            <img :src="hub.avatar" :width="40" />
          </td>
          <td>{{ hub.title }}</td>
          <td>
            <amount :value="hub.bet" />
          </td>
          <td>{{ hub.type }}</td>
          <td>{{ hub.players }}</td>
          <td>
            <a :href="'https://www.faceit.com/en/hub/' + hub.uid + '/'" target="_blank" class="btn btn-primary">
              Join
            </a>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import { groupBy, sortBy } from 'lodash'

  export default
  {
    head() {
      return {
        title: 'Play',
      }
    },

    async asyncData({ app }) {
      const { data } = await app.$axios.get('/hub')

      return {
        hubs: data.hubs,
      }
    },

    data() {
      return {
      }
    },

    computed: {
      match() {
        const match = this.$auth.user.current_match

        if (! match) {
          return null
        }

        const teams = groupBy(sortBy(match.players, user => user.uid !== this.$auth.user.uid), 'pivot.team')

        return Object.entries(teams).map(([id, users]) => {
          let title = users[0].nickname
          let image = users[0].avatar || '/img/noavatar.jpeg'

          return {
            roster: users,
            id, image, title,
          }
        })
      }
    }
  }
</script>
