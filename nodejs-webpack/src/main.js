// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import axios from 'axios'
import Vuex from 'vuex'
import VueI18n from "vue-i18n"


Vue.config.productionTip = false;
/**
 * @deprecated 推荐使用 HttpUtil.axiosPost()。该方法对请求进行进一步封装，可简化请求参数
 * @type {AxiosStatic}
 */
Vue.prototype.axios = axios;
Vue.use(ElementUI);
Vue.use(Vuex);
Vue.use(VueI18n);

// 组建通信模块
import store from './store/index'
// 多语言模块
import i18n from './utils/i18n'

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  i18n,
  components: { App },
  template: '<App/>'
});
