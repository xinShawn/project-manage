import Vue from 'vue'
import Router from 'vue-router'
import main from '../views/main/main'
import missions from '../views/missions/missions'
import missionsDetail from '../views/missions/detail/detail'
import missionsIndex from '../views/missions/index/index'
import projects from '../views/projects/projects'
import backend from '../views/backend/backend'
import loginIndex from '../views/login/index'
import loginLogin from '../views/login/login'
import loginInit from '../views/login/init'

Vue.use(Router)

let router = new Router({
  routes: [
    {path: '/', redirect: 'login'},
    // 系统初始化页面模块
    {path: '/login', component: loginIndex, children: [
        {path: '/', redirect: 'login'},
        // 登录页面
        {path: 'login', component: loginLogin},
        // 初始化系统页面
        {path: 'init', component: loginInit}
        ]
    },
    {path: '/main', name: 'main', component: main},
    {path: '/missions', name: 'missions', component: missions, children: [
        {path: '/', redirect: 'index'},
        {path: 'index', component: missionsIndex},
        {path: 'detail', component: missionsDetail}
        ]
    },
    {path: '/projects', name: 'projects', component: projects},
    {path: '/backend', name: 'backend', component: backend}
  ],
});
//
// /**
//  * 路由守卫
//  */
// router.beforeEach(before);

export default router
