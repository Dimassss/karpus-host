import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex'

// #PLUGINS
import vuetify from './plugins/vuetify';

// #STORE
import storeData from './store/index.js';
const store  = new Vuex.Store(storeData);

//Main pages
import App from './pages/index.vue'


new Vue({
    store,
    vuetify,
    el: '#app',
    components: { App },
    ready: function(){
        this.$scrollSet()
    }
});
