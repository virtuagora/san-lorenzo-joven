<template>
  <div>
    <div v-if="!loginFacebook && !register && !reset">
      <b-notification type="is-warning" v-if="error">
            <i class="fa fa-info-circle fa-fw"></i> Usuario o contraseña incorrectos. Por favor, vuelva a intentarlo.
        </b-notification>
      <form ref="formLocalLogin" :action="loginUrl" method="POST">
      <div class="field">
        <div class="control has-icons-left" >
          <input type="email" name="email" v-model.lazy="loginEmail" required v-validate="'required|email'" data-vv-validate-on="change" class="input is-medium has-text-centered" :class="{'is-danger': errors.has('email')}" placeholder="Dirección de email">
          <span class="icon is-left">
            <i class="fas fa-envelope fa-fw"></i>
          </span>
        </div>
      </div>
      <div class="field">
        <div class="control has-icons-left">
          <input type="password" name="password" v-model.lazy="loginPassword" required v-validate="'required'" data-vv-validate-on="change" class="input is-medium has-text-centered" :class="{'is-danger': errors.has('password')}" placeholder="Contraseña">
          <span class="icon is-left">
            <i class="fas fa-lock fa-fw"></i>
          </span>
        </div>
      </div>
        <span class="help is-danger" v-show="errors.has('email')"><i class="fas fa-times-circle fa-fw"></i> Error. Debe ser un email bien formado</span>          
        <span class="help is-danger" v-show="errors.has('password')"><i class="fas fa-times-circle fa-fw"></i> Error. La contraseña no puede ser vacia</span>          
      <div class="buttons">
          <button @click="submitLogin" class="button is-medium is-primary is-fullwidth" :class="{'is-loading': isLoading}">
            <i class="fas fa-sign-in-alt fa-lg"></i>&nbsp;&nbsp;Entrar a mi cuenta</button>

          <a @click="reset = true" class="button is-white is-fullwidth">
            <i class="fas fa-question-circle fa-fw fa-lg"></i>
            &nbsp;&nbsp;¡Olvidé mi contraseña!
          </a>
      </div>
      </form>
      <br>
      <div v-if="allowSignUp == '1'">
        <div class="strike">
          <span class="is-size-5">¿Aún no te hiciste una cuenta?</span>
        </div>
        <br>
        <div class="field">
          <div class="control">
            <button @click="register = true" class="button is-link is-medium is-fullwidth">
              <i class="fas fa-user-plus fa-fw fa-lg"></i>
              &nbsp;&nbsp;¡Registrate!
            </button>
            <br>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="notification is-warning is-size-7">
          <i class="fas fa-exclamation-triangle fa-fw"></i> {{ noSignupMessage }}
        </div>
      </div>
    </div>
    <registro-email :sign-up-url="signUpUrl" :google-key="googleKey" @abort="register = false" v-if="register"></registro-email>
    <reset-password :reset-password="resetPassword" :google-key="googleKey" @abort="reset = false" v-if="reset"></reset-password>
    <b-loading :active.sync="isLoading"></b-loading>    
  </div>
</template>

<script>
import RegistroEmail from "./RegistroEmail";
import ResetPassword from "./ResetPassword";
export default {
  props: ["message", "loginUrl", 'googleKey', "signUpUrl", "homeUrl", "resetPassword", "error", "allowSignUp", "noSignupMessage"],
  components: {
    RegistroEmail,
    ResetPassword
  },
  data() {
    return {
      loginFacebook: false,
      register: false,
      reset: false,
      loginEmail: "",
      loginPassword: "",
      isLoading: false
    };
  },
  methods: {
    submitLogin: function() {
       this.$validator
        .validateAll()
        .then(result => {
          if (!result) {
            this.$buefy.snackbar.open({
              message: "Error. Email mal formado o contraseña vacia",
              type: "is-danger",
              actionText: "Cerrar"
            });
            return false;
          }
          this.isLoading = true;
          this.$refs.formLocalLogin.submit();
        })
        .catch(error => {
          this.$buefy.snackbar.open({
            message: "Error inesperado",
            type: "is-danger",
            actionText: "Cerrar"
          });
          return false;
        });
    },
  }
};
</script>

