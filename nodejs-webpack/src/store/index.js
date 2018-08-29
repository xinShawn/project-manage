import Vue from 'Vue'
import Vuex from 'vuex'
import auth from './mudules/auth'

Vue.use(Vuex)

const isStrict = process.env.NODE_ENV !== 'production'

let index = new Vuex.Store({
  modules: {
    auth: auth
  },
  /**
   * 是否适用严格模式，取决于环境。只有生产环境不用
   */
  strict: isStrict
})

export default index
