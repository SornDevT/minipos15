<template lang="">
    <div>
      <h1>Report Page</h1>  <br> <span>Token: {{ store.get_token }}</span> <br>
      Permission: {{ store.get_pm }}
    </div>
</template>
<script>
import { useStore } from '../Store/auth';
export default {
    setup() {
      const store = useStore();
      return { store }
    }
}
</script>
<style lang="">
    
</style>