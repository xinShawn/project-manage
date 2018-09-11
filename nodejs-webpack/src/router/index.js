import Vue from 'vue'
import Router from 'vue-router'
import main from '../views/main/main'
import Mission from '../views/mission/Mission'
import MissionsHome from '../views/mission/MissionHome'
import MissionsDetail from '../views/mission/MissionDetail'
import Project from '../views/project/Project'
import backend from '../views/backend/backend'
import Login from '../views/login/Login'
import LoginLogin from '../views/login/LoginLogin'
import LoginInit from '../views/login/LoginInit'

Vue.use(Router)

let router = new Router({
  routes: [
    {path: '/', redirect: 'login'},
    // 系统初始化页面模块
    {path: '/login', component: Login, children: [
        {path: '/', redirect: 'login'},
        // 登录页面
        {path: 'login', component: LoginLogin},
        // 初始化系统页面
        {path: 'init', component: LoginInit}
        ]
    },
    {path: '/main', name: 'main', component: main},
    {path: '/mission', name: 'mission', component: Mission, children: [
        {path: '/', redirect: 'home'},
        {path: 'home', component: MissionsHome},
        {path: 'detail/:id  ', name:'detail', component: MissionsDetail}
        ]
    },
    {path: '/project', name: 'project', component: Project},
    {path: '/backend', name: 'backend', component: backend}
  ],
});
//
// /**
//  * 路由守卫
//  */
// router.beforeEach(before);

export default router
