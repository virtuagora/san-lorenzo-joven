<template>
  <section>
    <img src="/assets/img/ppj-color.svg" class="image is-pulled-right" width="40" alt="">
    <h1 class="title is-3">3. Confirmación</h1>
    <h1 class="subtitle is-5">Revisá y confirmá los proyectos que elegiste para votar.</h1>
    <hr>
    <img src="/assets/img/icons/mark-project-round.svg" class="image is-48x48 is-pulled-right">
    <h1 class="title is-5">Estos son los proyectos que elegiste</h1>
    <h1 class="subtitle is-6">(Podés cambiarlo antes de enviar tu voto)</h1>
      <div class="notification is-project" v-for="voteProyecto in voteProyectos" :key="voteProyecto.id">
        <h1 class="title is-4 is-marginless has-text-white">{{voteProyecto.name}}</h1>
        <p class="some-good-effects has-text-white">Por <span class="is-600">{{getWho(voteProyecto)}}</span> - {{getShortDescription(voteProyecto.objective,150)}}</p>
      </div>
      <b-message type="is-success" v-if="voteProyectos.length == 0">
        <div class="has-text-centered">
        No seleccionaste proyectos.<br><span class="is-size-7">Se considera tu voto como voto en blanco en esta categoría.</span>
        </div>
      </b-message>
      <button v-on:click.prevent="$router.push({ name: 'PrivateStep1'})" class="button is-primary is-outlined is-fullwidth is-medium">
      <i class="fas fa-reply fa-fw "></i>&nbsp;Cambiar mi selección
    </button> 
      <hr>
    <div class="is-clearfix">
    <button v-on:click.prevent="$router.push({ name: 'PrivateConfirm'})" class="button is-primary is-rounded is-medium is-pulled-right">
      ¡Confirmo mi elección!&nbsp;
      <i class="fas fa-arrow-right fa-fw "></i>
    </button>
    </div>
  </section>
</template>

<script>
import { indexOf, without } from 'lodash';

export default {
  data(){
    return {

    }
  },
  beforeMount: function() {

  },
  methods: { 
    getWho(project){
      return project.author_names + ' ' + project.author_surnames
    },
    // getDistrict: function(id) {
    //   switch (id) {
    //     case 1:
    //       return "Norte";
    //     case 2:
    //       return "Centro";
    //     case 3:
    //       return "Sur";
    //   }
    // },
    getShortDescription: function(text, limit) {
      if (text.length > limit) {
        for (let i = limit; i > 0; i--) {
          if (
            text.charAt(i) === " " &&
            (text.charAt(i - 1) != "," ||
              text.charAt(i - 1) != "." ||
              text.charAt(i - 1) != ";")
          ) {
            return text.substring(0, i) + "...";
          }
        }
      } else {
        return text;
      }
    },
  },
  computed: {
    voteProyectos: function() {
      return this.$store.state.voteProyectos;
    },
  }
};
</script>

<style lang="scss" scoped>
.media-right .control{
  margin: 1px 0;
}
.is-checkbox{
  cursor: pointer;
}
.some-good-effects{
  line-height: normal;
  font-size:0.85rem;
}
</style>

