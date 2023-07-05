<template>
  <section>
    <div class="notification is-primary">
     <h1 class="title is-3 is-marginless"><i class="fas fa-user"></i>&nbsp;Datos del responsable</h1>
    <p><span class="is-600">Estos campos no serán visibles publicamente, son a efecto de la convocatoria a propuestas</span>.</p>
    </div>
    <div class="columns">
      <div class="column">
        <div class="field">
          <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.author_names')}">
            <i class="fas fa-caret-right"></i>&nbsp;Nombre
          </h1>
          <div class="control">
            <input
              v-model="project.author_names"
              data-vv-name="project.author_names"
              data-vv-as="'Nombre(s) del autor'"
              type="text"
              v-validate="'required|min:2|max:100'"
              class="input is-large"
              placeholder="Requerido *"
            >
            <span v-show="errors.has('project.author_names')" class="help is-danger">
              <i class="fas fa-times-circle fa-fw"></i>
              &nbsp;{{errors.first('project.author_names')}}
            </span>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.author_surnames')}">
            <i class="fas fa-caret-right"></i>&nbsp;Apellido
          </h1>
          <div class="control">
            <input
              v-model="project.author_surnames"
              data-vv-name="project.author_surnames"
              data-vv-as="'Apellido(s) del autor'"
              type="text"
              v-validate="'required|min:2|max:100'"
              class="input is-large"
              placeholder="Requerido *"
            >
            <span v-show="errors.has('project.author_surnames')" class="help is-danger">
              <i class="fas fa-times-circle fa-fw"></i>
              &nbsp;{{errors.first('project.author_surnames')}}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="field">
          <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.author_phone')}">
            <i class="fas fa-caret-right"></i>&nbsp;Telefono de contacto
          </h1>
          <div class="control">
            <input
              v-model="project.author_phone"
              data-vv-name="project.author_phone"
              data-vv-as="'Telefono del autor'"
              type="text"
              v-validate="'required|min:2|max:100'"
              class="input is-large"
              placeholder="Requerido *"
            >
            <span v-show="errors.has('project.author_phone')" class="help is-danger">
              <i class="fas fa-times-circle fa-fw"></i>
              &nbsp;{{errors.first('project.author_phone')}}
            </span>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.author_email')}">
            <i class="fas fa-caret-right"></i>&nbsp;Correo electrónico
          </h1>
          <div class="control">
            <input
              v-model="project.author_email"
              data-vv-name="project.author_email"
              data-vv-as="'Email del autor'"
              type="text"
              v-validate="'required|email|min:2|max:100'"
              class="input is-large"
              placeholder="Requerido *"
            >
            <span v-show="errors.has('project.author_email')" class="help is-danger">
              <i class="fas fa-times-circle fa-fw"></i>
              &nbsp;{{errors.first('project.author_email')}}
            </span>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.author_dni')}">
            <i class="fas fa-caret-right"></i>&nbsp;DNI
          </h1>
          <div class="control">
            <input
              v-model="project.author_dni"
              data-vv-name="project.author_dni"
              data-vv-as="'DNI del autor'"
              type="text"
              v-validate="'required|min:2|max:20'"
              class="input is-large"
              placeholder="Requerido *"
            >
            <span v-show="errors.has('project.author_dni')" class="help is-danger">
              <i class="fas fa-times-circle fa-fw"></i>
              &nbsp;{{errors.first('project.author_dni')}}
            </span>
          </div>
        </div>
      </div>
    </div>
     <div class="notification is-primary">
     <h1 class="title is-3"><i class="fas fa-list"></i>&nbsp;Datos de la propuesta</h1>
     </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.type')}">
        <i class="fas fa-caret-right"></i>&nbsp;Elegí la temática de la propuesta
      </h1>
      <h1 class="subtitle is-6">
        <span class="has-text-link">* Requerido.</span> ¿De que temática es la propuesta?
      </h1>
      <div class="control">
        <!-- <div class="select is-large is-fullwidth">
          <select
            data-vv-name="project.type"
            data-vv-as="'Categoría'"
            v-validate="'required'"
            v-model="project.type"
            placeholder="Seleccione la temática de la propuesta"
          >
            <option :value="null" disabled>- Selecciona la temática de la propuesta -</option>
            <option value="Formación y Educación">Formación y Educación</option>
            <option value="Arte y Diseño">Arte y Diseño</option>
            <option value="Tecnología y Comunicación">Tecnología y Comunicación</option>
            <option value="Salud, Fitness y Deportes">Salud, Fitness y Deportes</option>
            <option value="Medioambiente">Medioambiente</option>
            <option value="Otro">Otro</option>
          </select>
        </div> -->
        <input
          v-model="project.type"
          data-vv-name="project.type"
          data-vv-as="'Tematica del proyecto'"
          type="text"
          v-validate="'required|min:2|max:250'"
          class="input is-large"
          placeholder="Requerido *"
        >
        <span v-show="errors.has('project.type')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.type')}}
        </span>
      </div>
    </div>
    <!-- <section class="box" v-if="project.type == 'institucional'">
      <div class="message is-primary">
        <div class="message-body">

     <h1 class="title is-3"><i class="fas fa-users"></i>&nbsp;Datos de la organización</h1>
     <div class="content">
        <p>Como el proyecto es del tipo institucional, complete los datos que corresponde a la institución civil.</p>
        <p class="is-size-4"><i class="fas fa-exclamation-triangle"></i>&nbsp;<b>IMPORTANTE: Requisitos para proyectos institucionales.</b></p>
        <p>Las instituciones que presenten proyectos institucionales deben enviar copia del estatuto, del acta de constitución de autoridades, y constancia de IGPJ antes del 6 de julio.</p>
        <p>Las que participaron en ediciones anteriores de pp, y ya presentaron los documentos requeridos, están eximidos, excepto que se haya producido una renovación de autoridades, con posterioridad a la presentada. En ese caso presentar el último acta.</p>
        <p class="is-size-5"><i class="fas fa-info-triangle"></i><b>¡Todos estos documentos se pueden subir a la web luego de haber creado la web!</b></p>
     </div>
        </div>
     </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.organization_name')}">
          <i class="fas fa-caret-right"></i>&nbsp;Nombre de la organización
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span>
        </h1>
        <div class="control">
          <input
            v-model="project.organization_name"
            data-vv-name="project.organization_name"
            data-vv-as="'Nombre'"
            type="text"
            v-validate="'required|min:2|max:250'"
            class="input is-large"
            placeholder="Requerido *"
          >
          <span v-show="errors.has('project.organization_name')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('project.organization_name')}}
          </span>
        </div>
      </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.organization_legal_entity')}">
          <i class="fas fa-caret-right"></i>&nbsp;Nombre de la entidad legal
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span>
        </h1>
        <div class="control">
          <input
            v-model="project.organization_legal_entity"
            data-vv-name="project.organization_legal_entity"
            data-vv-as="'Entidad legal'"
            type="text"
            v-validate="'required|min:2|max:250'"
            class="input is-large"
            placeholder="Requerido *"
          >
          <span v-show="errors.has('project.organization_legal_entity')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('project.organization_legal_entity')}}
          </span>
      </div>
    </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.organization_address')}">
          <i class="fas fa-caret-right"></i>&nbsp;Domicilio legal de la organización
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span>
        </h1>
        <div class="control">
          <input
            v-model="project.organization_address"
            data-vv-name="project.organization_address"
            data-vv-as="'Nombre del proyecto'"
            type="text"
            v-validate="'required|min:2|max:250'"
            class="input is-large"
            placeholder="Requerido *"
          >
          <span v-show="errors.has('project.organization_address')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('project.organization_address')}}
          </span>
        </div>
      </div>
    </section> -->
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.district_id')}">
        <i class="fas fa-caret-right"></i>&nbsp;Seleccioná la zona donde se creará el proyecto
      </h1>
      <h1 class="subtitle is-6">
        <span class="has-text-link">* Requerido.</span> En otras palabras, en que Zona se ideó el proyecto.
      </h1>
      <div class="control">
        <div class="select is-large is-fullwidth" :class="{'is-loading': districtsLoading}">
          <select
            data-vv-name="project.district_id"
            data-vv-as="'Distrito'"
            v-validate="'required'"
            v-model="project.district_id"
            placeholder="Seleccione el distrito"
          >
            <option :value="null" disabled>- Selecciona la zona -</option>
            <option
              v-for="district in districts"
              :key="district.id"
              :value="district.id"
            >{{district.name}}</option>
          </select>
        </div>
        <span v-show="errors.has('project.district_id')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.district_id')}}
        </span>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.benefited_districts')}">
        <i class="fas fa-caret-right"></i>&nbsp;Seleccioná las zonas beneficiadas por la propuesta
      </h1>
      <h1 class="subtitle is-6">
        <span class="has-text-link">* Requerido.</span> ¿A que zonas beneficia la propuesta?
      </h1>
      <div class="control">
        <b-checkbox v-model="project.benefited_districts" v-for="district in districts" :key="'checkbox-district-' + district.id" :native-value="district.id">
          {{district.name}}
        </b-checkbox>
      </div>
    </div>
    <div class="message is-info">
      <div class="message-body">
        <i class="fas fa-info-circle fa-fw"></i>
        &nbsp;Barrios por Zona:
        <ul>
          <li v-for="district in districts">
            <strong>{{district.name}}:</strong>
            <span v-for="(neighbourhood, index) in district.neighbourhoods">
              {{neighbourhood.name}}{{ index < district.neighbourhoods.length - 1 ? ' / ' : '.' }}
            </span>
          </li>
        </ul>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.name')}">
        <i class="fas fa-caret-right"></i>&nbsp;Nombre del proyecto
      </h1>
      <h1 class="subtitle is-6">
        <span class="has-text-link">* Requerido.</span> ¡Ponele un lindo nombre para que la gente lo reconozca!
      </h1>
      <div class="control">
        <input
          v-model="project.name"
          data-vv-name="project.name"
          data-vv-as="'Nombre del proyecto'"
          type="text"
          v-validate="'required|min:2|max:250'"
          class="input is-large"
          placeholder="Requerido *"
        >
        <span v-show="errors.has('project.name')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.name')}}
        </span>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.participants')}">
        <i class="fas fa-caret-right"></i>&nbsp; Datos personales de los responsables del proyecto (PRIVADO. DATOS SENSIBLES)
      </h1>
      <h1 class="subtitle is-6">
        <span class="has-text-link">* Requerido. Privado para el admin.</span> Completa por cada responsable del proyecto: Nombre, Apellido, DNI, Email y Telefono.
      </h1>
      <div class="control">
        <b-input
        v-model="project.participants"
        data-vv-name="project.participants"
        data-vv-as="'Participantes'"
        v-validate="'required|min:10|max:2000'"
        type="textarea"
        minlength="10"
        maxlength="2000"
        rows="3"
        placeholder="Requerido *"
        :readonly="!editable"
        ></b-input>
        <span v-show="errors.has('project.participants')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.participants')}}
        </span>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.authors')}">
        <i class="fas fa-caret-right"></i>&nbsp; Nombre y Apellido de los responsables del proyecto (PUBLICO)
      </h1>
      <h1 class="subtitle is-6">
        <span class="has-text-link">* Requerido. Publico.</span> Completá en una linea nombre y apellido de cada autor del proyecto separado en comas. Ej: Julio Maria, Susana Estela.
      </h1>
      <div class="control">
        <b-input
        v-model="project.authors"
        data-vv-name="project.authors"
        data-vv-as="'Autores'"
        v-validate="'required|min:10|max:2000'"
        type="textarea"
        minlength="10"
        maxlength="2000"
        rows="3"
        placeholder="Requerido *"
        :readonly="!editable"
        ></b-input>
        <span v-show="errors.has('project.authors')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.authors')}}
        </span>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.description')}">
          <i class="fas fa-caret-right"></i>&nbsp; Definición del problema
      </h1>
      <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> ¿Cual es la problematica que atiende la propuesta?. Tenes un máximo de 2000 caracteres
        </h1>
        <div class="control">
          <b-input
          v-model="project.description"
          data-vv-name="project.description"
          data-vv-as="'Definición del problema'"
          v-validate="'required|min:10|max:2000'"
          type="textarea"
          minlength="10"
          maxlength="2000"
          rows="3"
          placeholder="Requerido *"
          :readonly="!editable"
          ></b-input>
          <span v-show="errors.has('project.description')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('project.description')}}
          </span>
        </div>
      </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.objective')}">
          <i class="fas fa-caret-right"></i>&nbsp;Objetivo del proyecto
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> Defina el objetivo del proyecto. <i>¿Que se busca lograr con este proyecto?</i>. Tenes un máximo de 2000 caracteres.
        </h1>
        <div class="control">
          <b-input
            v-model="project.objective"
            data-vv-name="project.objective"
            data-vv-as="'Objetivo'"
            v-validate="'required|min:10|max:2000'"
            type="textarea"
            minlength="10"
            maxlength="2000"
            rows="3"
            placeholder="Requerido *"
            :readonly="!editable"
          ></b-input>
          <span v-show="errors.has('project.objective')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('project.objective')}}
          </span>
        </div>
      </div>
      <div class="field">
        <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.about')}">
          <i class="fas fa-caret-right"></i>&nbsp;Descripcion del proyecto
        </h1>
        <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> Contanos que se quiere hacer, donde va a ser el lugar de ejecucion, etc. (Cualquier detalle de como se ejecutará). Tenes un máximo de 2000 caracteres.
        </h1>
        <div class="control">
          <b-input
            v-model="project.about"
            data-vv-name="project.about"
            data-vv-as="'Descripcion del proyecto'"
            v-validate="'required|min:10|max:2000'"
            type="textarea"
            minlength="10"
            maxlength="2000"
            rows="3"
            placeholder="Requerido *"
            :readonly="!editable"
          ></b-input>
          <span v-show="errors.has('project.about')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('project.about')}}
          </span>
        </div>
      </div>
      <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.benefited_population')}">
          <i class="fas fa-caret-right"></i>&nbsp; Población beneficiada
      </h1>
      <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> ¿Cual es la población identificada que se verá beneficiada con el proyecto?. Tenes un máximo de 2000 caracteres
      </h1>
      <div class="control">
        <b-input
          v-model="project.benefited_population"
          data-vv-name="project.benefited_population"
          data-vv-as="'Poblacion beneficiada'"
          v-validate="'required|min:10|max:2000'"
          type="textarea"
          minlength="10"
          maxlength="2000"
          rows="3"
          placeholder="Requerido *"
          :readonly="!editable"
        ></b-input>
        <span v-show="errors.has('project.benefited_population')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.benefited_population')}}
        </span>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.community_contributions')}">
          <i class="fas fa-caret-right"></i>&nbsp; Aportes comunitarios
      </h1>
      <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> ¿Requiere de aportes de otras instituciones u organizaciones? ¿Cuáles? Tenes un máximo de 2000 caracteres
      </h1>
      <div class="control">
        <b-input
          v-model="project.community_contributions"
          data-vv-name="project.community_contributions"
          data-vv-as="'Contribución a la comunidad'"
          v-validate="'required|min:10|max:2000'"
          type="textarea"
          minlength="10"
          maxlength="2000"
          rows="3"
          placeholder="Requerido *"
          :readonly="!editable"
        ></b-input>
        <span v-show="errors.has('project.community_contributions')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.community_contributions')}}
        </span>
      </div>
    </div>
    <div class="field">
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.resources')}">
          <i class="fas fa-caret-right"></i>&nbsp; Descripción recursos necesarios para la ejecución
      </h1>
      <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> Detalla que tipo de recurso humano se requiere, materiales, etc. Tenes un máximo de 2000 caracteres
      </h1>
      <div class="control">
        <b-input
          v-model="project.resources"
          data-vv-name="project.resources"
          data-vv-as="'Recursos'"
          v-validate="'required|min:10|max:2000'"
          type="textarea"
          minlength="10"
          maxlength="2000"
          rows="3"
          placeholder="Requerido *"
          :readonly="!editable"
        ></b-input>
        <span v-show="errors.has('project.resources')" class="help is-danger">
          <i class="fas fa-times-circle fa-fw"></i>
          &nbsp;{{errors.first('project.resources')}}
        </span>
      </div>
    </div>
    <div class="field">
      <div class="notification is-primary">
     <h1 class="title is-3 is-marginless"><i class="fas fa-file-invoice-dollar"></i>&nbsp;El presupuesto de tu propuesta</h1>
      <p>Detalle como se compone el presupuesto de la propuesta.</p>
    </div>
     <b-message type="is-warning">
        <b><i class="fas fa-exclamation-triangle"></i>&nbsp;IMPORTANTE: El limite a presupuestar en proyectos es de $ {{this.budget}}</b>
      </b-message>
      <h1 class="title is-4" :class="{'has-text-danger': errors.has('project.budget')}">
          <i class="fas fa-caret-right"></i>&nbsp; Items del presupuesto
      </h1>
      <h1 class="subtitle is-6">
          <span class="has-text-link">* Requerido.</span> Defina cada item del presupuesto que presenta la propuesta. Escribí descripción del mismo, y el monto en pesos (sin centavos)
      </h1>
      <div class="field is-grouped" v-if="editable">
        <p class="control is-expanded">
          <b-input
            size="is-medium"
            v-model="inputItemDescripcion"
            maxlength="300"
            placeholder="Descripción Item"
          ></b-input>
        </p>
        <p class="control">
          <input
            class="input is-medium"
            v-model.number="inputItemMonto"
            data-vv-name="inputItemMonto"
            data-vv-as="'Monto'"
            v-validate="'numeric'"
            type="text"
            placeholder="Monto en AR$"
          >
          <span v-if="errors.has('inputItemMonto')" class="help is-danger">
            <i class="fas fa-times-circle fa-fw"></i>
            &nbsp;{{errors.first('inputItemMonto')}}
          </span>
          <span v-else class="help">Ingrese números sin decimal, puntos o comas</span>
        </p>
        <p class="control">
          <b-tooltip
            :label="disableAddItem ? 'Falta información' : 'Agregar!'"
            :type="disableAddItem ? 'is-danger' : 'is-primary'"
            position="is-bottom"
          >
            <button @click="addItem" class="button is-primary is-medium" :disabled="disableAddItem">
              <i class="fas fa-plus"></i>&nbsp;Agregar
            </button>
          </b-tooltip>
        </p>
      </div>
      <input
        type="hidden"
        v-model="project.budget"
        data-vv-name="project.budget"
        data-vv-as="'Presupuesto'"
        v-validate="'required'"
      >
      <b-table 
        :data="project.budget"
        bordered>
         <b-table-column v-slot="props" label="Descripción" >
            {{ props.row.description }}
          </b-table-column>
         <b-table-column v-slot="props" label="Monto" width="100" centered>
            $ {{ props.row.amount }}
          </b-table-column>
         <b-table-column v-slot="props" label="Quitar" width="40" centered v-if="editable">
            <a @click="removeItem(props.index)">
              <i class="fas fa-times has-text-danger"></i>
            </a>
          </b-table-column>
       <template #empty>
        <section class="section">
            <div class="content has-text-grey has-text-centered">
                <p>
                   <i class="far fa-sad-cry fa-2x"></i>
                </p>
                <p>No se han ingresado items en el presupuesto</p>
                </div>
            </section>
        </template>
      </b-table>
       <span v-show="errors.has('project.budget')" class="help is-danger">
        <i class="fas fa-times-circle fa-fw"></i>
        &nbsp;{{errors.first('project.budget')}}
      </span>
      <br>
      <div class="notification is-link">
        <h1 class="subtitle is-5">Monto total del presupuesto ingresado: <span class="is-700"> $ {{montoTotal}}</span></h1>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ["project", "budget", "editing", "editable"],
  data() {
    return {
      districtsLoading: false,
      districts: [],
      inputItemDescripcion: null,
      inputItemMonto: null,
      canComplete: true
    };
  },
  created: function() {
    if (!this.project.budget) {
      this.project.budget = [];
      // this.isInitialized = true;
    }
  },
  mounted: function() {
    this.districtsLoading = true;
    this.$http
      .get("/api/distritos?with=neighbourhoods")
      .then(response => {
        this.districts = response.data;
        this.districtsLoading = false;
      })
      .catch(error => {
        this.canComplete = false;
        console.error(error.message);
        this.$buefy.snackbar.open({
          message:
            "Error de conexion con el servidor. No pudimos rescatar los distritos. Sin esto no se va a poder completar el formulario. Por favor, volvé a intentarlo más tarde o reintentá volviendo a cargar la pagina.",
          type: "is-danger",
          actionText: "Cerrar",
          indefinite: true
        });
        this.districtsLoading = true;
      });
  },
  methods: {
    addItem: function() {
      this.$validator
        .validate("inputItemMonto", this.inputItemMonto)
        .then(result => {
          if (result) {
            if (!this.disableAddItem) {
              if (
                parseFloat(this.inputItemMonto) + this.montoTotal >
                this.budget
              ) {
                this.$buefy.snackbar.open(
                  "El item excede el total permitido ($" + this.budget + ")"
                );
                return;
              }
              this.project.budget.push({
                description: this.inputItemDescripcion,
                amount: this.inputItemMonto
              });
              this.inputItemDescripcion = null;
              this.inputItemMonto = null;
            }
          } else {
            this.$buefy.snackbar.open(
              "El monto debe ser un número sin coma ni punto decimal"
            );
          }
        });
    },
    removeItem: function(index) {
      this.project.budget.splice(index, 1);
    },
    validateForm: function() {
      let promise = new Promise((resolve, reject) => {
        this.$validator.validateAll().then(result => {
          if (!result) {
            console.log(
              "Proyecto: Hay errores en los datos. Reviselos antes de guardar los campos"
            );
            return resolve(result);
          }
          console.log("Proyecto: OK");
          return resolve(result);
        });
      });
      return promise;
    }
  },
  computed: {
    montoTotal: function() {
      const reducer = (accumulator, item) =>
        accumulator + parseFloat(item.amount);
      return this.project.budget.reduce(reducer, 0);
    },
    disableAddItem: function() {
      return (
        this.inputItemDescripcion == null ||
        this.inputItemDescripcion == "" ||
        this.inputItemMonto == null ||
        this.inputItemMonto == ""
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.field:not(:last-child) {
  margin-bottom: 20px;
}
</style>

