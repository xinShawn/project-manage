/**
 * 国际化模块
 */
import Vue from 'vue'
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

const messages = {
  "en-US": require("./../assets/i18n/en-US"),
  "zh-CN": require("./../assets/i18n/zh-CN"),
  "zh-TW": require("./../assets/i18n/zh-TW")
};

export default new VueI18n({
  //定义默认语言
  locale: 'zh-CN',
  messages
});
