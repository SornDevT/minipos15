<template lang="">
    <div class="card">
  <h5 class="card-header">ລາຍການສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        <div class="d-flex justify-content-end">
            <button class="btn btn-info me-2" :disabled="CheckForm" @click="SaveStore()" >ບັນທຶກ</button>
            <button class="btn btn-danger" @click="CancelStore()" >ຍົກເລີກ</button>
        </div>
        <div class="row">
            <div class="col-md-4 text-center" style="position: relative;">
              <button v-if="FormStore.image" type="button" @click="RemoveIMG()" class="btn rounded-pill btn-icon btn-danger" style="position: absolute; top: 0px; right: 30px;">
                <i class='bx bx-x fs-4'></i>
              </button>

              <img :src="imagePreview" @click="$refs.img_store.click()" class="cursor-pointer" style="width:60%" />

              <input type="file" accept="image/png, image/gif, image/jpeg" ref="img_store" style="display:none;" @change="onSelect" >
            </div>
            <div class="col-md-8">
                    {{ FormStore }}
                    <div class="mb-2"> 
                        <label for="p-name" class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
                        <input type="text" v-model="FormStore.name" class="form-control" id="p-name" placeholder="..." >
                    </div>

                    <div class="mb-2"> 
                        <label for="p-amount" class="form-label fs-6">ຈຳນວນ:</label>
                        <cleave class="form-control" :options="options" v-model="FormStore.amount" id="p-amount" placeholder="..." />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2"> 
                                <label for="p-price-buy" class="form-label fs-6">ລາຄາຊື້:</label>
                                <cleave :options="options" class="form-control" v-model="FormStore.price_buy" id="p-amount" placeholder="..." />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2"> 
                                <label for="p-price-sell" class="form-label fs-6">ລາຄາຂາຍ:</label>
                                <cleave :options="options" class="form-control" v-model="FormStore.price_sell" id="p-amount" placeholder="..." />
                            </div>
                        </div>
                    </div>
               
            </div>
        </div>
    </div>


    <div v-if="!ShowForm" class="table-responsive text-nowrap">
        <div class="d-flex justify-content-between mb-2">
            <div class="d-flex ">
              <!-- {{ Sort }} -->
              <div class="d-flex align-items-center me-2 cursor-pointer " @click="ChangeSort()">
                <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
              </div>
              <select class="form-select" v-model="PerPage" @change="GetStore()">
                <option value="5" >05</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
              </select>
            </div>
            <div class="d-flex">
                <input type="text" class=" form-control me-2" v-model="Search" @keyup.enter = "GetStore()" placeholder="ຄົ້ນຫາ...">
                <button class="btn btn-primary" @click="AddStore()">ເພີ່ມໃໝ່</button>
            </div>
        </div>
        <button @click="showAlert">Hello world</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບພາບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          
          
          <tr v-for="list in StoreData.data" :key="list.id">
            <td> {{ list.id }} </td>
            <td>
            <img v-if="list.image" :src="url+'/assets/img/'+list.image" class="rounded" style="width:60px;" >
            <img v-else :src="url+'/assets/img/no_image.png'" class="rounded" style="width:60px;" >
            </td>
            <td>
             {{ list.name }}
            </td>
            <td> {{ list.price_buy }} </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item text-info" @click="EditStore(list.id)" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item text-danger" @click="DelStore(list.id)" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>
      <Pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />
    </div>


  </div>
</div>
</template>
<script>
import { useStore } from '../Store/auth';
import axios from 'axios';
export default {
    setup(){
        const store = useStore();
        return { store}
    },
    data() {
        return {
            imagePreview: window.location.origin + '/assets/img/upload_img.png',
            url: window.location.origin,
            Sort:'asc',
            PerPage: 5,
            Search:'',
            ShowForm:false,
            FormType:true,
            FormStore:{
                name:'',
                image:'',
                amount:'',
                price_buy:'',
                price_sell:''
            },
            StoreData:[],
            EditID:'',
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: ',',
                  delimiter: '.'
                }
        }
    },
    computed:{
        CheckForm(){
            if(this.FormStore.name == '' || this.FormStore.amount =='' || this.FormStore.price_buy =='' || this.FormStore.price_sell ==''){
                return true;
            } else {
                return false;
            }
        }
    },
    methods: {
      RemoveIMG(){
            this.FormStore.image = ''
            this.imagePreview = window.location.origin + '/assets/img/upload_img.png'
        },
      showAlert() {
      // Use sweetalert2

      this.$swal({
                  position:'top-end',
                  toast: true,
                  title: "Deleted!",
                  icon: "success",
                  showConfirmButton: false,
                  timer: 2500
                });

      // this.$swal({
      //     title: "Are you sure?",
      //     text: "You won't be able to revert this!",
      //     icon: "warning",
      //     showCancelButton: true,
      //     confirmButtonColor: "#3085d6",
      //     cancelButtonColor: "#d33",
      //     confirmButtonText: "Yes, delete it!"
      //   }).then((result) => {
      //     if (result.isConfirmed) {
      //       this.$swal({
      //         title: "Deleted!",
      //         text: "Your file has been deleted.",
      //         icon: "success"
      //       });
      //     }
      //   });
    },
    onSelect(event){

      console.log(event.target.files[0])
        // if(event.target.files[0].size>1024*1024){
        //   alert('NO Upload!!')
        // }
      this.FormStore.image = event.target.files[0];
      // ອ່ານໄຟລ໌ ເພື່ອໄປສະແດງຜົນ
          let reader = new FileReader()
            reader.readAsDataURL(this.FormStore.image)
            reader.addEventListener("load", function(){
                this.imagePreview = reader.result
            }.bind(this),false)


          // var reader = new FileReader();

    //Read the contents of Image File.
    // reader.readAsDataURL(event.target.files[0]);
    // reader.onload = function (e) {

    //   //Initiate the JavaScript Image object.
    //   var image = new Image();

    //   //Set the Base64 string return from FileReader as source.
    //   image.src = e.target.result;

    //   //Validate the File Height and Width.
    //   image.onload = function () {
        
    //     var height = this.height;
    //     var width = this.width;
    //     console.log('w='+width)
    //     if (height > 100 || width > 100) {
    //       alert("Height and Width must not exceed 100px.");
    //       return false;
    //     }
    //     alert("Uploaded image has valid Height and Width.");
    //     return true;
    //   };
    // };


    },
      ChangeSort(){
          if(this.Sort == 'asc'){
            this.Sort = 'desc'
          } else {
            this.Sort = 'asc'
          }
          this.GetStore()
      },
     AddStore(){

        this.FormStore.name = '';
        this.FormStore.image = '';
        this.FormStore.amount = '';
        this.FormStore.price_buy = '';
        this.FormStore.price_sell = '';
        this.imagePreview = window.location.origin + '/assets/img/upload_img.png'
        this.ShowForm = true;
        this.FormType = true;
     },
     EditStore(id){
      this.ShowForm = true; /// ສະແດງ Form
        this.FormType = false; 
        this.EditID = id;

        axios.get(`api/store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

          this.FormStore = res.data;
          if(res.data.image){
            this.imagePreview = window.location.origin + '/assets/img/'+ res.data.image;
          } else{
            this.imagePreview = window.location.origin + '/assets/img/upload_img.png'
          }
          

        }).catch((error)=>{
          console.log(error)
        })

     },
     SaveStore(){
            if(this.FormType){
                /// ເພີ່ມຂໍ້ມູນໃໝ່

              axios.post('api/store/add',this.FormStore, { headers:{ "Content-Type":"multipart/form-data" ,Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

                if(res.data.success){
                  this.ShowForm=false;
                  this.GetStore();

                  this.$swal({
                    position:'top-end',
                    toast: true,
                    title: res.data.message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2500
                  });
                } else {
                  this.$swal({
                  title: res.data.message,
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3500
                });
                }

              }).catch((error)=>{
                console.log(error)
              })
                
            } else {
                // ອັບເດດຂໍ້ມູນ
              axios.post(`api/store/update/${this.EditID}`,this.FormStore, { headers:{ "Content-Type":"multipart/form-data" ,Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

                  if(res.data.success){
                          this.ShowForm=false;
                          this.GetStore();

                          this.$swal({
                          position:'top-end',
                          toast: true,
                          title: res.data.message,
                          icon: "success",
                          showConfirmButton: false,
                          timer: 2500
                        });

                  } else {
                        this.$swal({
                        title: res.data.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3500
                      });
                  }

                  }).catch((error)=>{
                  console.log(error)
                  })
            }
     },
     CancelStore(){
        this.ShowForm = false;
     },
     DelStore(id){

      this.$swal({
          title: "ທ່ານແນ່ບໍ່?",
          text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "ຕົກລົງ",
          cancelButtonText:"ຍົກເລີກ"
        }).then((result) => {
          if (result.isConfirmed) {

            axios.delete(`api/store/delete/${id}`, { headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{
              if(res.data.success){
                this.$swal({
                  position:'top-end',
                  toast: true,
                  title: res.data.message,
                  icon: "success",
                  showConfirmButton: false,
                  timer: 2500
                });
                this.GetStore();
              } else {
                this.$swal({
                  title: res.data.message,
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3500
                });

              }
            }).catch((error)=>{
              console.log(error)
            })

          }
        });

      
     },
     GetStore(page){
        axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`, { headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

          this.StoreData = res.data;

        }).catch((error)=>{
          console.log(error.response.status);
          if(error.response.status){

            this.store.remove_token()
            this.store.remove_user()
            localStorage.removeItem("web_token")
            localStorage.removeItem("web_user")
            this.$router.push("/login")
            
          }
        })
     }
    },
    created(){
      this.GetStore();
    },
    watch:{
      Search(){
            if(this.Search ==''){
              this.GetStore()
            }
        }
     
    
  }
}
</script>
<style lang="">
    
</style>