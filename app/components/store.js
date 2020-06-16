import Vue from 'vue'
import Vuex from 'vuex'
import http from './http'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: null,
    expires: null,
    members: [],
    group: null,
    proyectos: [],
    voteProyectos: [],
    publicVoteCode: null,
    codeOnQuery: false,
    recaptcha: null
  },
  mutations: {
    removeProyecto: function(state, proyecto){
      state.voteProyectos = state.voteProyectos.filter( el => el.id !== proyecto.id );
    },
    addProyecto: function(state, proyecto){
      state.voteProyectos.push(proyecto);
    },
    resetPublicVote: function(state){
      state.voteProyectos = [];
      state.publicVoteCode = null;
      state.codeOnQuery = false;
      state.recaptcha = null;
    },
    restartPublicVote: function(state){
      state.voteProyectos = [];
      state.recaptcha = null;
    },
    bind: function (state, element) {
      Object.assign(state, element);
    },
  },
  actions: {
    // prepareData: function ({commit}, session){
    //   return new Promise((resolve, reject) => {
    //       commit('checkUser', session)
    //       if(session.id != null){
    //         // There is a session, get user.
    //         resolve(true)
    //       } else {
    //         // NO session, NO user
    //         resolve(false)
    //       }
    //   })
    // }
  },
  getters: {
    get: (state) => {
      return key => {return state[key]}
      // return state
    },
    // getUserGroup: (state) => {
    //   if(state.user != null && state.user.groups.length > 0){
    //   return state.user.groups[0]
    //   }
    //   return null;
    // }
  },
  plugins: [createPersistedState({
    key: 'pp-sl',
    paths: ['user', 'expires']
  })]
})

export default store;