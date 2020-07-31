<template>
  <div class="store__item">
    <img class="store__image" :src="item.image" />

    <div class="store__label">{{ title.weapon }}</div>
    <div class="store__skin">{{ title.skin }}</div>

    <amount :value="item.steam_price" />
  </div>
</template>

<script>
  export default
  {
    props: {
      item: Object,
    },

    computed: {
      title() {
        const baseTitle = this.item.title

        let quality = ''
        let skin = 'Default'
        let weapon = baseTitle
        let isStatTrak = false

        if (baseTitle.indexOf('|') !== -1)
        {
          let matches = /(.*?)\|(.*?)($|\()/g.exec(baseTitle)

          if (matches.length > 1)
          {
            weapon = matches[1].trim()

            if (weapon.indexOf('★ StatTrak™') !== -1)
            {
              isStatTrak = true
              weapon = weapon.replace('★ StatTrak™', '').trim()
            }
          }

          if (matches.length > 2) {
            skin = matches[2].trim()
          }
        }

        if (baseTitle.indexOf('(') !== -1)
        {
          let matches = /\((.*)\)/.exec(baseTitle)

          if (matches.length > 1) {
            quality = matches[1]
          }
        }

        return { isStatTrak, weapon, skin, quality }
      }
    }
  }
</script>
