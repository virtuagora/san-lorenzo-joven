<template>
    <section>
    <img src="/assets/img/ppj-color.svg" class="image is-pulled-right" width="40" alt="">
    <h1 class="title is-3">4. Envio</h1>
    <h1 class="subtitle is-5">¿Listo para enviar?</h1>
    <article class="media">
      <div class="media-left">
        <h1 class="title is-2 is-marginless"><i class="fas fa-info-circle"></i></h1>
      </div>
      <div class="media-content">
        <div class="content">
          <p>A continuación vamos a enviar tu voto. Te recordamos lo siguiente</p>
          <ul>
            <li>Tu voto será almacenado de forma <u>ANÓNIMA</u>, quitándole cualquier dato que pueda vincularlo con vos.</li>
            <li>Recordá que una vez que enviás tu voto online no vas a poder votar</li>
            <li>Por cualquier consulta que tengas, podés ponerte en contacto con el equipo de Presupuesto Participativo.</li>
          </ul>
        </div>
      </div>
    </article>
    <hr>
    <div class="has-text-centered">
      <h1 class="title is-primary is-4">¿Todo listo? ¡Haga clic para enviar su voto!</h1>
    <button v-on:click.prevent="$router.push({ name: 'PrivateSending'})" class="button is-primary is-medium is-rounded">
      <i class="fas fa-paper-plane fa-fw "></i>&nbsp;¡Enviar!
    </button>
    </div>
  </section>
</template>

<script>
export default {

}
</script>

