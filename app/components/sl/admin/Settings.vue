<template>
  <section>
     <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Edición actual</h1>
    <h2 class="subtitle is-6">
      Defina en el año de la edición actual. Todos los proyectos que se creen van a llevar este año.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <current-edition :value="theSettings['current-edition'].value"></current-edition>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Estado de la plataforma</h1>
    <h2 class="subtitle is-6">
      Defina en que estado se encuentra la plataforma
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <change-state :currentState="theSettings['current-state'].value" :states="theSettings['states'].value"></change-state>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Habilitar/Deshabilitar el registro de nuevos usuarios</h1>
    <h2 class="subtitle is-6">
      Active esta opcion para habilitar o deshabilitar el registro de nuevos usuarios. 
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <allow-signup :value="theSettings['allow-signup'].value"></allow-signup>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Mensaje en caso de no permitir el registro de nuevos usuarios</h1>
      <h2 class="subtitle is-6">
        Deje un mensaje por default, como "En este momento no se permite el registro de nuevos usuarios"
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <no-signup-message :value="theSettings['no-signup-message'].value"></no-signup-message>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Comienzo de la subida de propuestas</h1>
    <h2 class="subtitle is-6">
      Aquí pueden modificar la fecha en que abre el formulario para subir propuestas.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <proposals-launch :launch="theSettings['proposals-launch']"></proposals-launch>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Fecha de cierre de la subida de propuestas</h1>
    <h2 class="subtitle is-6">
      Aquí pueden modificar la fecha en que cierra el formulario para subir propuestas.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <proposals-deadline :deadline="theSettings['proposals-deadline']"></proposals-deadline>
    <hr>
     <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Habilitar/Deshabilitar el formulario de propuestas</h1>
    <h2 class="subtitle is-6">
      Active esta opcion para mostrar u ocultar el menú de "Subir propuestas", aun si se encuentra dentro de la fecha configurada. 
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <proposals-available :value="theSettings['proposals-available'].value"></proposals-available>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Refrescar cache</h1>
    <h2 class="subtitle is-6">
      ¿Errores de actualizacion? Haga clic para refrescar la cache (Puede utilizar el formato YYYYMMDD como protocolo)
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <refresh-cache :value="theSettings['refresh-cache'].value"></refresh-cache>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Comienzo de la votación</h1>
    <h2 class="subtitle is-6">
      Aquí pueden modificar la fecha en que abre la votación.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <vote-launch :launch="theSettings['vote-launch']"></vote-launch>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Fecha de cierre de la votación</h1>
    <h2 class="subtitle is-6">
      Aquí pueden modificar la fecha en que cierra la votación.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <vote-deadline :deadline="theSettings['vote-deadline']"></vote-deadline>
    <hr>
     <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Habilitar/Deshabilitar la votación</h1>
    <h2 class="subtitle is-6">
      Active esta opcion para mostrar u ocultar el menú de "Votar" y el modulo de votación, aun si la votación se encuentra dentro de la fecha configurada. 
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <vote-available :value="theSettings['vote-available'].value"></vote-available>
    <hr>
     <!-- <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Mostrar los resultados</h1>
    <h2 class="subtitle is-6">
      ¿Ya realizó el escrutinio? ¿Ya definió los ganadores? ¡Habilite la muestra de los resultados! 
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <show-results :value="theSettings['show-results'].value"></show-results>
    <hr> -->
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Presupuesto</h1>
    <h2 class="subtitle is-6">
      Aquí pueden modificar el valor máximo del presupuesto.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <budget-limit :value="theSettings['budget-limit'].value"></budget-limit>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Fechas de la urna</h1>
    <h2 class="subtitle is-6">
      Agregue o quite fechas donde la urna estará disponible.
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <calendar :value="theSettings['calendar'].value"></calendar>
    <hr>
    <h1 class="title is-4">
      <i class="fas fa-arrow-right fa-fw"></i> Mensaje en caso de mal clima</h1>
    <h2 class="subtitle is-6">
      ¡Deje un mensaje en caso de lluvia!
      <i class="fas fa-exclamation-triangle fa-fw"></i> Nota: Al modificar este dato, tu sesión se cerrará, tendras que volver a loguearte.
    </h2>
    <rain :value="theSettings['rain-message'].value"></rain>
  </section>
</template>

<script>
import CurrentEdition from "./settings/CurrentEdition";
import ChangeState from "./settings/ChangeState";
import ProposalsDeadline from "./settings/ProposalsDeadline";
import ProposalsLaunch from "./settings/ProposalsLaunch";
import ProposalsAvailable from "./settings/ProposalsAvailable";
import VoteDeadline from "./settings/VoteDeadline";
import VoteLaunch from "./settings/VoteLaunch";
import VoteAvailable from "./settings/VoteAvailable";
import ShowResults from "./settings/ShowResults";
import BudgetLimit from "./settings/BudgetLimit";
import Calendar from "./settings/Calendar";
import RefreshCache from "./settings/RefreshCache";
import AllowSignup from "./settings/AllowSignup";
import NoSignupMessage from "./settings/NoSignupMessage";
import Rain from "./settings/Rain";

export default {
  props: ["settings"],
  components: {
    CurrentEdition,
    ChangeState,
    ProposalsDeadline,
    ProposalsLaunch,
    ProposalsAvailable,
    VoteDeadline,
    VoteLaunch,
    VoteAvailable,
    ShowResults,
    BudgetLimit,
    Calendar,
    AllowSignup,
    NoSignupMessage,
    RefreshCache,
    Rain
  },
  data() {
    return {};
  },
  computed: {
    theSettings: function() {
      let settings = {};
      this.settings.forEach(x => {
        return (settings[x.key] = x);
      });
      return settings;
    }
  }
};
</script>
