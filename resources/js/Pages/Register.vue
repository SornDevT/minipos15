<template lang="">
     <div class="d-flex justify-content-center">

   
<div class="authentication-wrapper authentication-basic container-p-y col-md-4">
<div class="authentication-inner">
  <!-- Register -->
  <div class="card">
    <div class="card-body">
      <!-- Logo -->
      <div class="app-brand justify-content-center">
  
    
  
      </div>
      <!-- /Logo -->
      <p class="mb-4">ລົງທະບຽນ ຜູ້ໃຊ້ໃໝ່</p>

 
        <div class="mb-3">
          <label for="email" class="form-label fs-6">ຊື່ຜູ້ໃຊ້:</label>
          <input type="text" class="form-control" v-model="user_name"  placeholder="...." autofocus="">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
          <input type="text" class="form-control" v-model="user_email" id="email" name="email-username" placeholder="Enter your email or username" autofocus="">
        </div>
        <div class="mb-3 form-password-toggle">
          <div class="d-flex justify-content-between">
            <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
            
          </div>
          <div class="input-group input-group-merge">
            <input type="password" id="password" v-model="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
        </div>
        <div class="mb-3 form-password-toggle">
          <div class="d-flex justify-content-between">
            <label class="form-label fs-6" for="password">ຍືນຍັນລະຫັດຜ່ານ:</label>
            
          </div>
          <div class="input-group input-group-merge">
            <input type="password" class="form-control" v-model="password2" name="password" placeholder="············" aria-describedby="password">
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
        </div>

        <div class="alert alert-warning alert-dismissible" v-if="text_eror" role="alert">
          {{ text_eror }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
      
        <div class="mb-3">
          <button class="btn btn-primary d-grid w-100" type="submit" @click="Register()" >ລົງທະບຽນ</button>
        </div>


      <p class="text-center">
        <span>ມີ User ແລ້ວ!</span>
        <router-link to="/login" >
          <span>ເຂົ້າສູ່ລະບົບ</span>
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
        user_name:'',
        user_email:'',
        password:'',
        password2:'',
        text_eror:''
      }
    },
    methods: {
      Register(){
          if(this.user_name == '' || this.user_email == '' || this.password == ''){
            this.text_eror = 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!';
          } else {
            if(this.password == this.password2){
              this.text_eror = '';

              // ຍິງ http request
              axios.post('api/register',{
                form_user_name: this.user_name,
                form_email: this.user_email,
                form_password: this.password
              }).then((res)=>{


                // console.log(res);
                if(res.data.success){
                  this.text_eror = '';
                  this.user_name = '';
                  this.user_email = '';
                  this.password = '';
                  this.password2 = '';

                  // ໄປທີ່ໜ້າ Login
                  this.$router.push('/login');
                  
                } else {
                  this.text_eror = res.data.message;
                }


              }).catch((error)=>{
                console.log(error);
              })

            } else {
              this.text_eror = 'ລະຫັດຜ່ານບໍ່ຕົງກັນ!';
            }
          }
      }
    },
}
</script>
<style lang="">
    
</style>