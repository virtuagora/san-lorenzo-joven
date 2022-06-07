<template>
  <section>
    <b-autocomplete v-model="email" 
    :data="data" placeholder="Comience escribiendo el email" field="subject.display_name" 
    :loading="isFetching" @input="getAsyncData" @select="option => selected = option"
    size="is-medium">
      <template slot-scope="props">
        {{ props.option.subject.display_name }} - {{props.option.email}}
      </template>
      <template slot="empty">No se encontro un usuario con un email parecido a "{{email}}"</template>
    </b-autocomplete>
    <hr>
    <div class="notification has-text-centered" v-if="selected">
        <button class="delete" @click="selected = null"></button>
        <h2 class="title is-5">¿Desea agregar al usuario como servidor de votos?</h2>
        <h2 class="subtitle is-6">{{ selected.subject.display_name }} - {{selected.email}}</h2>
        <button @click="submitServiceUser" class="button is-primary is-fullwidth"><i class="fas fa-save fa-fw"></i>&nbsp;Agregar como servidor de votos</button>
    </div>
    <div class="content">
      <table class="table">
        <thead>
          <tr>
            <th>Avatar</th>
            <th>Nombre y apellido</th>
            <th>Email</th>
            <th class="has-text-centered">Quitar?</th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="serviceUser in currents" :key="serviceUser.id">
              <td>
                <avatar :username="serviceUser.subject.display_name" :size="30" :admin="true" />
              </td>
              <td>
                {{serviceUser.subject.display_name}}</td>
              <td>{{serviceUser.email}}</td>
              <td class="has-text-centered"><button @click="removeServiceUser(serviceUser.email)" class="button is-danger is-small"><i class="fas fa-trash fa-fw"></i></button></td>
            </tr>
            <tr v-if="currents == null || (currents && currents.length == 0)">
              <td colspan="3" class="has-text-centered">No hay servidores de votos</td>
            </tr>
        </tbody>
      </table>
    </div>
    <b-loading :is-full-page="true" :active.sync="isLoading"></b-loading>
  </section>
</template>

<script>
import { debounce } from "lodash";
import Avatar from "../utils/Avatar";
export default {
  props: ["getCandidatesUrl", "runServiceUser", "runRemoveServiceUser", "currents"],
  components: {
    Avatar
  },
  data: () => {
    return {
      admins: [],
      email: "",
      data: [],
      selected: null,
      isLoading: true,
      isFetching: false
    };
  },
  beforeMount: function() {
    // this.updateAdminList();
    this.isLoading = false;
  },
  methods: {
    submitServiceUser: function() {
      this.isLoading = true;
      this.$http
        .post(this.runServiceUser,{
            user_email: this.selected.email,
            role: 'verified'
        })
        .then(response => {
          this.$buefy.snackbar.open({
            message: "¡Nuevo servidor de votos agregado!",
            type: "is-success",
            actionText: "OK"
          });
          window.location.reload();
        })
        .catch(error => {
          console.error(error.message);
          this.$buefy.snackbar.open({
            message: "Error inesperado",
            type: "is-danger",
            actionText: "Cerrar"
          });
          this.isLoading = false;
        });
    },
    removeServiceUser: function(serviceUserEmail){
      this.isLoading = true;
      this.$http
        .delete(this.runRemoveServiceUser,{
          data: {
            user_email: serviceUserEmail,
            role: 'verified'
          }
        })
        .then(response => {
          this.$buefy.snackbar.open({
            message: `El rol de servidor de votos ha sido quitado del usuario ${serviceUserEmail}`,
            type: "is-success",
            actionText: "OK"
          });
          window.location.reload();
        })
        .catch(error => {
          console.error(error.message);
          this.$buefy.snackbar.open({
            message: "Error inesperado",
            type: "is-danger",
            actionText: "Cerrar"
          });
          this.isLoading = false;
        });
    },
    // updateAdminList: function(){
    //   this.isLoading = true;
    //   this.$http
    //     .get(this.urlGetAdmins)
    //     .then(response => {
    //       this.admins = response.data.data;
    //       this.isLoading = false;
    //     })
    //     .catch(error => {
    //       console.error(error.message);
    //       this.$buefy.snackbar.open({
    //         message: "Error inesperado",
    //         type: "is-danger",
    //         actionText: "Cerrar"
    //       });
    //       this.isLoading = false;
    //     });
    // },
    getAsyncData: debounce(function() {
      this.data = [];
      this.isFetching = true;
      this.$http
        .get(this.urlGetAdmins)
        .then(({ data }) => {
          data.forEach(item => this.data.push(item));
          this.isFetching = false;
        })
        .catch(error => {
          this.isFetching = false;
          throw error;
        });
    }, 500)
  },
  computed: {
    urlGetAdmins: function() {
      let query = [];
      query.push("email=" + this.email);
      return this.getCandidatesUrl.concat(
        query.length > 0 ? "?" : "",
        query.join("&")
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.table tr td {
  vertical-align: middle;
}
</style>