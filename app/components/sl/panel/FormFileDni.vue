<template>
  <section>
    <div class="box">
      <b-message>
        Pueden ser imagenes, escaneos, archivos PDF o documentos de Microsoft Word
        <br>Maximo: 3MB. Se aceptan .JPG, .JPEG, .PDF, .DOC o .DOCX
      </b-message>

      <form :action="formUrl" ref="formUsrFile" method="post" enctype="multipart/form-data">
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('gender')}">
          <i class="fas fa-caret-right"></i>&nbsp;Genero
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> A modos estadisticos, elija el genero que indica el DNI.
        </h1>
        <div class="control">
          <input type="hidden" name="gender" v-model="gender" v-validate="'required'" data-vv-as="'Genero'" data-vv-name="gender">
          <b-field>
            <b-radio-button v-model="gender" v-validate="'required'" size="is-large" native-value="M">
              Masculino
            </b-radio-button>
            <b-radio-button v-model="gender" size="is-large" native-value="F">
              Femenino
            </b-radio-button>
          </b-field>
          <span v-show="errors.has('gender')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>&nbsp;{{errors.first('gender')}}</span>
        </div>
      </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('notes')}">
          <i class="fas fa-caret-right"></i>&nbsp;Notas y aclaraciones
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Opcional.</span> Si queres aclarar algo, dejar una nota al equipo para que tenga en cuenta a la hora de validar tu cuenta, escribilo en este espacio.
        </h1>
        <div class="control">
          <input
            v-model="notes"
            name="notes"
            data-vv-name="notes"
            data-vv-as="'Notas y aclaraciones'"
            type="text"
            v-validate="'min:2|max:2000'"
            class="input is-large"
            placeholder="Opcional"
          >
          <span v-show="errors.has('notes')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('notes')}}
          </span>
          <input type="hidden" name="description" :value="descriptionFinal" v-if="descriptionFinal">
        </div>
      </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': !isFileOk && file !== null }">
          <i class="fas fa-caret-right"></i>&nbsp;Archivo para subir
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span>
        </h1>
        <b-field class="file is-medium">
          <b-upload v-model="file" :required="true" name="archivo">
            <a class="button is-link is-medium">
              <i class="fas fa-upload"></i>&nbsp;
              <span>Click para cargar</span>
            </a>
          </b-upload>
          <span class="file-name" style="max-width: none;" v-if="file">{{ file.name }}</span>
        </b-field>
        <p
          v-show="!isFileOk && file !== null"
          class="has-text-danger"
        >Requerido. Debe ser un archivo .JPG, .JPEG, .PDF, .DOC o .DOCX de hasta 3MB como máximo.</p>
        </div>
        <div class="field">
          <div class="control is-clearfix">
            <a
              @click="submit"
              type="submit"
              class="button is-primary is-medium is-pulled-right"
              :class="{'is-loading': isLoading}"
            >
              <i class="fa fa-paper-plane fa-fw"></i> Enviar
            </a>
          </div>
        </div>
      </form>
    </div>
    <b-loading :is-full-page="false" :active.sync="isLoading"></b-loading>
  </section>
</template>

<script>
export default {
  props: ["formUrl"],
  data() {
    return {
      gender: null,
      notes: null,
      file: null,
      isLoading: false,
      mimes: ['application/pdf','invalid/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','image/jpeg','image/pjpeg']
    };
  },
  methods: {
    submit: function() {
      this.$validator
        .validateAll()
        .then(result => {
          if (!result) {
            this.$snackbar.open({
              message: "Error en el formulario. Verifíquelo",
              type: "is-danger",
              actionText: "Cerrar"
            });
            return false;
          }
          this.isLoading = true;
          this.$refs.formUsrFile.submit();
        })
        .catch(error => {
          this.$snackbar.open({
            message: "Error inesperado",
            type: "is-danger",
            actionText: "Cerrar"
          });
          return false;
        });
    }
  },
  computed: {
    isFileOk: function() {
      if (this.file === null) return false;
      if (this.file && this.file.size > 3145728) return false;
      if (this.file && !this.mimes.includes(this.file.type)) return false;
      return true;
    },
    descriptionFinal: function(){
      return this.isOptional(this.description)
    }
  }
};
</script>