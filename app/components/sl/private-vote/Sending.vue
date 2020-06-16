<template>
  <section class="has-text-centered">
    <i class="fas fa-paper-plane fa-5x has-text-primary fa-fw animated rubberBand infinite"></i>
    <br>
    <br>
    <h2 class="title is-4">Enviando su voto...</h2>
    <h2 class="subtitle is-7">Aguarde unos segundos, usted será redirigido a la página de confirmación</h2>
    <form ref="sendingForm" :action="urlVote" method="POST">
      <input type="hidden" name="proyectos" :value="payloadProyectos" />
    </form>
  </section>
</template>

<script>
export default {
  props: ['urlVote'],
  mounted: function(){
    setTimeout(() => {
      this.$refs.sendingForm.submit();
    }, 1000);
  },
  computed: {
    voteProyectos: function() {
      return this.$store.state.voteProyectos;
    },
    payloadProyectos: function(){
      return this.voteProyectos.map(pro => {
        return pro.id
      }).join('&&')
    },
  }
}
</script>

<style>

</style>
