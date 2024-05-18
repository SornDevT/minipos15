import { createWebHistory, createRouter } from "vue-router";

import { useStore } from "../Store/auth";


export const routes = [
    {
        path:'/',
        redirect:'/store'
    },
    {
        name:'login',
        path:'/login',
        component: ()=> import('../Pages/Login.vue')
    },
    {
        name:'register',
        path:'/register',
        component: ()=> import('../Pages/Register.vue')
    },
    {
        name:'store',
        path:'/store',
        component: ()=> import('../Pages/Store.vue'),
        meta:{
            requiresAuth: true
        }
    },
    {
        name:'pos',
        path:'/pos',
        component: ()=> import('../Pages/Pos.vue'),
        meta:{
            requiresAuth: true
        }
    },
    {
        name:'transection',
        path:'/transection',
        component: ()=> import('../Pages/Transection.vue'),
        meta:{
            requiresAuth: true
        }
    },
    {
        name:'report',
        path:'/report',
        component: ()=> import('../Pages/Report.vue'),
        meta:{
            requiresAuth: true
        }
    },
    {
        name:'no_page',
        path:'/:pathMacth(.*)*',
        component: ()=> import('../Pages/NoPage.vue'),
        meta:{
            requiresAuth: true
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

router.beforeEach((to,from,next)=>{

    const token = localStorage.getItem('web_token');
    const user = localStorage.getItem('web_user');
    const store = useStore();

    if(token){
        store.set_token(token);
        store.set_user(JSON.parse(user));
    } else {
        store.remove_token()
        store.remove_user()
        localStorage.removeItem('web_token');
        localStorage.removeItem('web_user');
    }

    if(to.meta.requiresAuth){
        if(!token){
            return next({
                path:'/login',
                replace: true
            });
        }
    }
    
    next();

})


export default router