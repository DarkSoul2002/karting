<template>
  <section >
    <article>
      <h3>Er zijn {{ aanbods.length }} soorten activiteiten </h3>
      <ul v-for="aanbod in aanbods" class="list-group">
        <li class="list-group-item text-primary">
          <h3 style="color: black">{{ aanbod.naam }}</h3>
          <p style="color: black">Beschrijving: {{ aanbod.beschrijving }}</p>
          <p style="color: black">Min. leeftijd: {{ aanbod.minLeeftijd }}</p>
          <p style="color: black">Duur: {{ aanbod.tijdsduur }}</p>
          <p style="color: black">Prijs: {{ aanbod.prijs }}</p>
        </li>
      </ul>
      <p>
        Let op, voor het karten zijn dichte schoenen verplicht.
        Karten met een korte broek is niet toegestaan. Wij hebben overalls ter beschikking,
        maar probeer indien mogelijk een lange broek aan te doen of mee te nemen.
      </p>
    </article>
    <figure>
      <img class="img-responsive center-block" style="width:30%" src='img/kart.jpg' alt="kart" />
    </figure>
  </section>
</template>

<script>
import axios from 'axios'

export default {
  name: "aanbod",
  data() {
    return {
      aanbods: {}
    }
  },
  async created() {
    const response = await axios.get('/aanbodapi')
    this.aanbods = response.data
  },

}
</script>

<style scoped>

</style>