import { defineStore } from "pinia";
export const useStore = defineStore('auth',{
    state: ()=>({
        token: '12345678900000',
        user:null,
        permistion: 'aaaaasas123456'
    }),
    getters:{
        get_token:(state)=> state.token,
        get_user:(state)=> state.user,
        get_pm:(state)=> state.permistion
    },
    actions:{
        set_token(new_token){
            this.token = new_token
        },
        set_user(new_user){
            this.user = new_user
        },
        remove_token(){
            this.token = null
        },
        remove_user(){
            this.user = null
        },
    }
})