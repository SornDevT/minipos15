<template lang="">
    <div class="d-flex justify-content-center">

   
    <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
      
              <span class="app-brand-logo demo">

                </span>
              <span class=" fs-4 fw-bold">MiniPos 15</span>
      
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">ສະບາຍດີ</h4>
          <p class="mb-4">ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

         
            <div class="mb-3">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="email" name="email-username" placeholder="Enter your email or username" autofocus="">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input :type="show_pass" id="password" v-model="password" @keyup.enter="Login()" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer" @click="show_pass=='password'?show_pass='text':show_pass='password'" >
                  <i class="bx bx-hide" v-if="show_pass=='password'" ></i>
                  <i class="bx bx-show" v-if="show_pass=='text'" ></i>
                </span>
              </div>
            </div>

            <div class="alert alert-warning alert-dismissible" v-if="check_email_text || check_pass_text" role="alert">
          {{ check_email_text }} {{ check_pass_text }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
          
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit" @click="Login()" :disabled="check_form_login" >ເຂົ້າສູ່ລະບົບ</button>
            </div>
     

          <p class="text-center">
            <span>ບໍ່ມີ User, ລົງທະບຽນໃໝ່?</span>
            <router-link to="/register" >
              <span>ລົງທະບຽນ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
      return {
        email:'',
        password:'',
        text_error:'',
        check_email_text:'',
        check_pass_text:'',
        show_pass:'password'
      }
    },
    computed:{
      check_form_login(){

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // ກວດອີເມວລ໌
        if(this.email){
          if(!emailRegex.test(this.email)){
            this.check_email_text = 'ອີເມວລ໌ບໍ່ຖຶກຕ້ອງ';
          } else {
            this.check_email_text = '';
          }
        } else {
          this.check_email_text = '';
        }

        // ກວດຊອບລະຫັດຜ່ານ
        if(this.password){
          if(this.password.length<6){
            this.check_pass_text = ', ລະຫັດຜ່ານຕ້ອງຫຼາຍກ່ວາ 5 ຕົວອັກສອນ';
          } else {
            this.check_pass_text = '';
          }
        } else {
          this.check_pass_text = '';
        }

        // ກວດຊອບຄວາມຖຶກຕ້ອງ ແລະ ປິດປຸ່ມ
        if(!emailRegex.test(this.email) || this.password.length<6){
          return true;
        } else {
          return false;
        }


      }
    },
    methods: {
      Login(){
          if(this.email !='' && this.password !=''){
              axios.post('api/login',{
                login_email: this.email,
                login_password: this.password
              }).then((res)=>{
                if(res.data.success){
                  this.email = ''
                  this.password = ''

                  // ບັນທຶກ Token ແລະ ຂໍ້ມູນຜູ້ໃຊ້ໄວ້ໃນ LocalStorage
                  localStorage.setItem('web_token',res.data.token);
                  localStorage.setItem('web_user',JSON.stringify(res.data.user_data));

                  this.$router.push('/');

                  //console.log(res.data)

                } else {
                  this.check_pass_text = res.data.message;
                }
              }).catch((error)=>{
                console.log(error)
              })
          }
      }
    },
}
</script>
<style lang="">
    
</style>