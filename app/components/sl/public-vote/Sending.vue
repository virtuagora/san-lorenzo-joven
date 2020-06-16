<template>
  <section class="has-text-centered">
    <i class="fas fa-paper-plane fa-5x has-text-primary fa-fw animated rubberBand infinite"></i>
    <br>
    <br>
    <h2 class="title is-4">Enviando su voto...</h2>
    <h2 class="subtitle is-7">Aguarde unos segundos, usted será redirigido a la página de confirmación</h2>
    <!-- <form ref="sendingForm" action="urlVote" method="POST">
      <input type="hidden" name="proyectos" :value="payloadProyectos" />
    </form> -->
  </section>
</template>

<script>
export default {
  props: ['urlVote'],
  mounted: function(){
    setTimeout(() => {
      this.submit();
    }, 1000);
  },
  methods: {
    submit: function(){
      this.$http.post(this.urlVote, this.payload)
      .then( response => {
        this.$snackbar.open({
          message: response.data.message || "Boleta enviada",
          type: "is-success",
          actionText: "OK!",
        });
        this.$router.push({name: 'PublicSuccess'})
      }).
      catch(err => {
        this.$snackbar.open({
          message: err.response.data.message || 'Se recibio un error al guardar el voto',
          type: "is-danger",
          actionText: "Cerrar",
        });
        switch(err.response.data.error){
          case 'comusExceeded':
          case 'invalidComus':
            this.$router.push({name: 'PublicErrorInvalidVote'})
            break;
          case 'invalidCode':
          case 'notSentCode':
            this.$router.push({name: 'PublicErrorInvalidCode'})
            break;
          case 'usedCode':
            this.$router.push({name: 'PublicErrorUsedCode'})
            break;
          case 'invalidCaptcha':
            this.$router.push({name: 'PublicErrorInvalidCaptcha'})
            break;
          default:
            this.$router.push({name: 'PublicErrorInvalid'})
            break;
        }
      })
    },
  },
  computed: {
    payload: function(){
      return {
        captcha: this.recaptcha,
        codigo: this.publicVoteCode,
        proyectos: this.payloadProyectos,
      }
    },
    publicVoteCode: function() {
      return this.$store.state.publicVoteCode;
    },
    recaptcha: function() {
      return this.$store.state.recaptcha;
    },
    voteProyectos: function() {
      return this.$store.state.voteProyectos;
    },
    payloadProyectos: function(){
      return this.voteProyectos.map(pro => {
        return pro.id.toString()
        // return pro.id
      })
    },
  }
}
</script>

<style>

</style>
