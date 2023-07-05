<template>
  <section>
    <form-project-admin ref="FormProjectAdmin" :project.sync="project" :budget="budget" :editable="true"></form-project-admin>
    <hr>
    <button class="button is-primary is-large is-fullwidth" @click="submit" v-if="!response.replied"><i class="fas fa-save fa-fw"></i> Guardar</button>
    <div class="message is-success" v-show="response.replied && response.ok">
      <div class="message-body">
        <i class="fas fa-check fa-fw"></i>&nbsp;<b>¡Genial!</b> ¡La propuesta ha sido guardada correctamente!
      </div>
    </div>
    <b-loading :is-full-page="false" :active.sync="isLoading"></b-loading>
  </section>
</template>

<script>
import FormProjectAdmin from "../utils/FormProjectAdmin";
export default {
  props: ["formUrl", "budget"],
  components: {
    FormProjectAdmin
  },
  data() {
    return {
      isLoading: false,
      project: {
        name: null,
        type: null,
        district_id: null,
        benefited_districts: [],
        participants: null,
        authors: null,
        objective: null,
        description: null,
        about: null,
        benefited_population: null,
        community_contributions: null,
        resources: null,
        budget: [],
        author_names: null,
        author_surnames: null,
        author_phone: null,
        author_email: null,
        author_dni: null,
        organization_name: null,
        organization_legal_entity: null,
        organization_address: null,
      },
      response: {
        replied: false,
        ok: false
      } 
    };
  },
  methods: {
    submit: function() {
      this.isLoading = true
      this.$refs.FormProjectAdmin
        .validateForm()
        .then(response => {
          if (response) {
            // Valid
            console.log("Sending form!");
            this.isLoading = true;
            this.$http
              .post(this.formUrl, this.payload)
              .then(response => {
                this.$buefy.snackbar.open({
                  message: "¡Propuesta guardada!",
                  type: "is-success",
                  actionText: "¡Genial!"
                });
                this.isLoading = false;
                this.response.replied = true;
                this.response.ok = true;
              })
              .catch(error => {
                console.error(error.message);
                this.isLoading = false;
                this.$buefy.snackbar.open({
                  message: "Error inesperado",
                  type: "is-danger",
                  actionText: "Cerrar",
                  indefinite: true
                });
              });
          } else {
            // Not Valid
            this.isLoading = false;
            this.$buefy.snackbar.open({
              message: "Faltan datos o algunos son incorrectos. Verifíquelos.",
              type: "is-danger",
              actionText: "Cerrar",
              indefinite: true
              });
          }
        })
        .catch(error => {
          console.error(error.message);
          this.isLoading = false;
          this.$buefy.snackbar.open({
            message: "Error inesperado",
            type: "is-danger",
            actionText: "Cerrar",
            indefinite: true
          });
        });
    }
  },
  computed: {
    payload: function() {
      let payload = {
        name: this.project.name,
        type: this.project.type,
        district_id: this.project.district_id,
        participants: this.project.participants,
        authors: this.project.authors,
        objective: this.project.objective,
        description: this.project.description,
        about: this.project.about,
        benefited_population: this.project.benefited_population,
        benefited_districts: this.project.benefited_districts,
        community_contributions: this.project.community_contributions,
        resources: this.project.resources,
        budget: this.project.budget,
        author_names: this.project.author_names,
        author_surnames: this.project.author_surnames,
        author_phone: this.project.author_phone,
        author_email: this.project.author_email,
        author_dni: this.project.author_dni,
        organization_name: null,
        organization_legal_entity: null,
        organization_address: null
      };
      return payload;
    }
  }
};
</script>

<style>
</style>
