<template>
  <section>
    <table class="table" style="table-layout: fixed">
      <caption>
        Dit zijn alle beschikbare activiteiten
      </caption>
      <thead>
      <tr>
        <td>datum</td>
        <td>tijd</td>
        <td>soort activiteit</td>
        <td>beschikbaar</td>
        <td>prijs</td>
        <td>schrijf in</td>
      </tr>
      </thead>
      <tbody>
      <tr v-for="beschikbaar in beschikbareActiviteiten" :key="beschikbaar.id">
        <td>
          {{ beschikbaar.datum }}
        </td>
        <td>
          {{ beschikbaar.tijd }}
        </td>
        <td>
          {{ beschikbaar.naam }}
        </td>
        <td>
          {{ beschikbaar.maxDeelnemers - beschikbaar.totaalRegistraties }} van de {{ beschikbaar.maxDeelnemers }}
        </td>
        <td>
          &euro;{{ beschikbaar.prijs }}
        </td>
        <td title="schrijf in voor activiteit">
          <a href="#" @click="inschrijven(beschikbaar.id);">
            <span class="glyphicon glyphicon-plus" style="color:red"></span>
          </a>
        </td>
      </tr>
      </tbody>
    </table>

    <table class="table" style="table-layout: fixed">
      <caption>
        Dit zijn de door jou ingeschreven activiteiten
      </caption>
      <thead>
      <tr>
        <td>datum</td>
        <td>tijd</td>
        <td>soort activiteit</td>
        <td>beschikbaar</td>
        <td>prijs</td>
        <td>schrijf uit</td>
      </tr>
      </thead>
      <tbody>
      <tr v-for="ingeschreven in ingeschrevenActiviteiten" :key="ingeschreven.id">
        <td>
          {{ ingeschreven.datum }}
        </td>
        <td>
          {{ ingeschreven.tijd }}
        </td>
        <td>
          {{ ingeschreven.naam }}
        </td>
        <td>
          {{ ingeschreven.maxDeelnemers - ingeschreven.totaalRegistraties }} van de {{ ingeschreven.maxDeelnemers }}
        </td>
        <td>
          &euro;{{ ingeschreven.prijs }}
        </td>
        <td title="schrijf in voor activiteit">
          <a href="#" @click="uitschrijven(ingeschreven.id);">
            <span class="glyphicon glyphicon-minus" style="color:red"></span>
          </a>
        </td>
      </tr>
      <tr>
        <td>
        </td>
        <td>
        </td>
        <td>
          Totaal prijs:
        </td>
        <td>
          &euro; {{ totaal }}
        </td>
        <td>
        </td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'activiteiten',
  data() {
    return {
      user: {},
      beschikbareActiviteiten: {},
      ingeschrevenActiviteiten: {},
      totaal: {}
    };
  },
  async created() {
    const response = await axios.get('/deelnemer/activiteitenapi');
    this.user = response.data[0];
    this.beschikbareActiviteiten = response.data[1];
    this.ingeschrevenActiviteiten = response.data[2];
    this.totaal = response.data[3];
  },
  methods: {
    uitschrijven(id) {
      axios.get('uitschrijven/' + id);
      const index = this.ingeschrevenActiviteiten.findIndex(item => item.id === id);
      this.tijdelijk = this.ingeschrevenActiviteiten.splice(index,  1);
      this.beschikbareActiviteiten.push(this.tijdelijk[0]);
      location.reload();

    },
    inschrijven(id) {
      axios.get('inschrijven/' + id);
      const index = this.beschikbareActiviteiten.findIndex(item => item.id === id);
      this.tijdelijk = this.beschikbareActiviteiten.splice(index, 1);
      this.ingeschrevenActiviteiten.push(this.tijdelijk[0]);
      location.reload();
    },
  }
};
</script>

<style scoped>

</style>