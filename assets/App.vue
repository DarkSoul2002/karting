<template>
  <div id="app">
    <div class="container" style="background-color: white">
      <header>
        <div class="row" style="margin-top: 20px">

          <div class="hidden-xs col-sm-2 ">
            <img src="/img/logo.png" alt="kartcentrum" class="pull-left img-responsive">
          </div>
          <div class="col-sm-10">
            <h1>Kartcentrum <span class="text-danger"> MAX</span></h1>

          </div>

        </div>
      </header>
      <nav class="navbar navbar-default" style="margin-bottom: 0px">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-fire"></span> </a>
          </div>

          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav" v-if="this.user">
              <li>
                <router-link to="/deelnemer/activiteiten">Activiteiten</router-link>
              </li>
              <li>
                <router-link to="/user/profile">Profiel</router-link>
              </li>
            </ul>
            <div v-else>
              <ul class="nav navbar-nav">
                <li>
                  <router-link to="/">Home</router-link>
                </li>
                <li>
                  <router-link to="aanbod">Aanbod</router-link>
                </li>
                <li>
                  <a href="/registreren">Registreren</a>
                </li>
                <li>
                  <router-link to="contact">Contact</router-link>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="/login">Inloggen</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <figure>
        <img style="margin-bottom: 20px" class="img-responsive" src='/img/kart-wide.jpg'/>
      </figure>

      <router-view/>

      <hr>
      <footer>

        <img class="pull-right img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px"
             src='/img/linkedin.jpg'/>
        <img class="pull-right img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px"
             src='/img/tweet.jpg'/>
        <img class="pull-right img-thumbnail " width="40" style="margin-top: -10px;margin-bottom: 10px"
             src='/img/pinterest.png'/>

        <p class="text-muted text-center">&copy;afdeling applicatieontwikkelaar Tinwerf 10, 2544 ED Den Haag.
          Telefoon:088
          666 3600 </p>
      </footer>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import router from './routes';

export default {
  name: 'App',
  data() {
    return {
      user: {}
    }
  },
  async created() {
    const response = await axios.get('/userapi');
    this.user = response.data;
    console.log(this.user);
  },
}
</script>
