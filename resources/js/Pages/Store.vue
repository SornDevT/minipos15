<template lang="">
    <div class="card">
  <h5 class="card-header">ລາຍການສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        <div class="d-flex justify-content-end">
            <button class="btn btn-info me-2" :disabled="CheckForm" >ບັນທຶກ</button>
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
          
          
          <tr>
            <td>00000</td>
            <td>Jerry Milton</td>
            <td>
             333333
            </td>
            <td>44444</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item text-info" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item text-danger" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>
    </div>


  </div>
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
            ShowForm:false,
            FormType:true,
            FormStore:{
                name:'',
                image:'',
                amount:'',
                price_buy:'',
                price_sell:''
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
     AddStore(){
        this.ShowForm = true;
        this.FormType = true;
     },
     EditStore(){
        this.FormType = false;
     },
     SaveStore(){
            if(this.FormType){
                /// ເພີ່ມຂໍ້ມູນໃໝ່
                
            } else {
                // ອັບເດດຂໍ້ມູນ

            }
     },
     CancelStore(){
        this.ShowForm = false;
     }
    },
    
}
</script>
<style lang="">
    
</style>