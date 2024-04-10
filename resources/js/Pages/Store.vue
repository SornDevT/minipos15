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
            <div class="col-md-4">1111</div>
            <div class="col-md-8">
                    {{ FormStore }}
                    <div class="mb-2"> 
                        <label for="p-name" class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
                        <input type="text" v-model="FormStore.name" class="form-control" id="p-name" placeholder="..." >
                    </div>

                    <div class="mb-2"> 
                        <label for="p-amount" class="form-label fs-6">ຈຳນວນ:</label>
                        <input type="text" class="form-control" v-model="FormStore.amount" id="p-amount" placeholder="..." >
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2"> 
                                <label for="p-price-buy" class="form-label fs-6">ລາຄາຊື້:</label>
                                <input type="text" class="form-control" v-model="FormStore.price_buy" id="p-amount" placeholder="..." >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2"> 
                                <label for="p-price-sell" class="form-label fs-6">ລາຄາຂາຍ:</label>
                                <input type="text" class="form-control" v-model="FormStore.price_sell" id="p-amount" placeholder="..." >
                            </div>
                        </div>
                    </div>
               
            </div>
        </div>
    </div>


    <div v-if="!ShowForm" class="table-responsive text-nowrap">
        <div class="d-flex justify-content-between mb-2">
            <div class="d-flex ">
              <div class="d-flex align-items-center me-2">
                <i class='bx bx-sort-up fs-4'></i>
              </div>
              <select class="form-select">
                <option>01</option>
                <option>02</option>
              </select>
            </div>
            <div class="d-flex">
                <input type="text" class=" form-control me-2" placeholder="ຄົ້ນຫາ...">
                <button class="btn btn-primary" @click="AddStore()">ເພີ່ມໃໝ່</button>
            </div>
        </div>
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
            <td>No</td>
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
            EditID:''
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
     AddStore(){

        this.FormStore.name = '';
        this.FormStore.image = '';
        this.FormStore.amount = '';
        this.FormStore.price_buy = '';
        this.FormStore.price_sell = '';
        this.ShowForm = true;
        this.FormType = true;
     },
     EditStore(id){
      this.ShowForm = true; /// ສະແດງ Form
        this.FormType = false; 
        this.EditID = id;

        axios.get(`api/store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

          this.FormStore = res.data;

        }).catch((error)=>{
          console.log(error)
        })

     },
     SaveStore(){
            if(this.FormType){
                /// ເພີ່ມຂໍ້ມູນໃໝ່

              axios.post('api/store/add',this.FormStore, { headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

                if(res.data.success){
                  this.ShowForm=false;
                  this.GetStore();
                }

              }).catch((error)=>{
                console.log(error)
              })
                
            } else {
                // ອັບເດດຂໍ້ມູນ
              axios.post(`api/store/update/${this.EditID}`,this.FormStore, { headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{

                  if(res.data.success){
                    this.ShowForm=false;
                    this.GetStore();
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

      axios.delete(`api/store/delete/${id}`, { headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{
        if(res.data.success){
          this.GetStore();
        }
      }).catch((error)=>{
        console.log(error)
      })

     },
     GetStore(page){
        axios.get(`api/store?page=${page}`).then((res)=>{

          this.StoreData = res.data;

        }).catch((error)=>{
          console.log(error);
        })
     }
    },
    created(){
      this.GetStore();
    }
    
}
</script>
<style lang="">
    
</style>