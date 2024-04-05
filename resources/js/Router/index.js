import { createWebHistory, createRouter } from "vue-router";

import { useStore } from "../Store/auth";

const authMiddleware = (to, from, next) =>{
    const token = localStorage.getItem('web_token');
    const user = localStorage.getItem('web_user');
    const store = useStore();

    if(token){
        // ຖ້າຫາກວ່າມີ token
        store.set_token(token);
        store.set_user(user);
        next();
    } else {
        // ບໍ່ມີ Token
        next({
            path:'/login',
            replace: true
        })
    }
}

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
            middleware: [authMiddleware]
        }
    },
    {
        name:'pos',
        path:'/pos',
        component: ()=> import('../Pages/Pos.vue'),
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name:'transection',
        path:'/transection',
        component: ()=> import('../Pages/Transection.vue'),
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name:'report',
        path:'/report',
        component: ()=> import('../Pages/Report.vue'),
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name:'no_page',
        path:'/:pathMacth(.*)*',
        component: ()=> import('../Pages/NoPage.vue'),
        meta:{
            middleware: [authMiddleware]
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
    if(to.meta.middleware){
        to.meta.middleware.forEach(middleware=>middleware(to,from,next))
    } else {
        if(to.path == '/login' || to.path == '/'){
            if(token){
                next({
                    path:'/store',
                    replace: true
                })
            } else {
                next();
            }
        } else {
            next();
        }
    }
})


export default router