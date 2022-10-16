import Vue from 'vue'
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import Scrollspy from 'vue-scrollspy';
import Vuex from 'vuex';

Vue.use(Vuetify);
Vue.use(Scrollspy);
Vue.use(Vuex);

const opts = {
    icons: {
        iconfont: 'mdiSvg', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
    },
};

export default new Vuetify(opts)
