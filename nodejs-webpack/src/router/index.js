import Vue from 'vue'
import Router from 'vue-router'

import Login from '../views/login/Login'
import LoginLogin from '../views/login/LoginLogin'
import LoginInit from '../views/login/LoginInit'

import Main from '../views/main/Main'

import Mission from '../views/mission/Mission'
import MissionsHome from '../views/mission/MissionHome'
import MissionsDetail from '../views/mission/MissionDetail'

import Project from '../views/project/Project'

import Backend from '../views/backend/Backend'
import BackendAuthUser from '../views/backend/BackendAuthUser'

Vue.use(Router);

let router = new Router({
  routes: [
    // 默认页
    {path: '/', redirect: 'login'},
    // 系统初始化页面模块
    {path: '/login', component: Login, children: [
        {path: '/', redirect: 'login'},
        // 登录页面
        {path: 'login', component: LoginLogin},
        // 初始化系统页面
        {path: 'init', component: LoginInit},
      ],
    },
    // 主页（我的地盘）
    {path: '/main', name: 'main', component: Main},
    // 任务
    {path: '/mission', name: 'mission', component: Mission, children: [
        {path: '/', redirect: 'home'},
        {path: 'home', name: 'home', component: MissionsHome},
        {path: 'detail', name: 'detail', component: MissionsDetail},
      ],
    },
    // 项目
    {path: '/project', name: 'project', component: Project},
    // 后台
    {path: '/backend', name: 'backend', component: Backend, children: [
        {path: 'auth_user', name: 'auth_user', component: BackendAuthUser},
      ],
    },
  ],
});
//
// /**
//  * 路由守卫
//  */
// router.beforeEach(before);

export default router
