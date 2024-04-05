<template lang="">
    <div>
        <h1>Store Page</h1>
        <hr>
        {{ store.get_token }} <hr>
        {{ store.get_pm }}
        <br>
        <input type="text" v-model="new_token">
        <button @click="setToken()" >Save</button>
    </div>
</template>
<script>
import { useStore } from '../Store/auth';
export default {
    setup(){
        const store = useStore();
        return { store}
    },
    data() {
        return {
            new_token:''
        }
    },
    methods: {
        setToken(){
            this.store.set_token(this.new_token)
        }
    },
    
}
</script>
<style lang="">
    
</style>