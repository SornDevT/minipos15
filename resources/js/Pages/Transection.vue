<template lang="">
    <div class="card">
  <h5 class="card-header">ການເຄື່ອນໄຫວທຸລະກຳ</h5>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
        <div class="d-flex justify-content-between mb-2">
            <div class="d-flex ">
              <!-- {{ Sort }} -->
              <div class="d-flex align-items-center me-2 cursor-pointer " @click="ChangeSort()">
                <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
              </div>
              <select class="form-select" v-model="PerPage" @change="GetTran()" >
                <option value="5" >05</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
              </select>
            </div>
            <div class="d-flex"> 
                <!-- {{month_type}} | {{dmy}} -->
                <div class="btn-group me-2" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" @click="month_type='m'"> <i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                    <button type="button" class="btn btn-secondary" @click="month_type='y'"> <i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
              </div>
                <input type="date" v-model="dmy" class=" form-control" >
               
            </div>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="fs-6" width="120">ວັນທີ່</th>
            <th class="fs-6" width="140">ເລກທີ່ທຸລະກຳ</th>
            <th class="fs-6"  width="140">ປະເພດທຸລະກຳ</th>
            <th class="fs-6">ລາຍລະອຽດ</th>
            <th class="fs-6"  width="150">ມູນຄ່າ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in TransectionData.data" :key="list.id">
            <td>{{ date(list.created_at) }}</td>
            <td>{{ list.tran_id }}</td>
            <td>{{ list.tran_type }}</td>
            <td>{{ list.tran_detail }}</td>
            <td class="text-end">{{ formatPrice(list.price) }}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="TransectionData" :offset="4" @paginate="GetTran($event)" />
    </div>
  </div>
</div>
</template>
<script>
import moment from 'moment'
import axios from 'axios'
import { useStore } from '../Store/auth'
export default {
    setup(){
        const store = useStore()
        return { store }
    },
    data() {
        return {
            TransectionData:{
                data:[]
            },
            PerPage:10,
            Sort:'desc',
            month_type:'m',
            dmy: new Date().toISOString().slice(0,10),
        }
    },
    components:{
        moment
    },
    methods:{
        date(value){
            return moment(value).format("DD/MM/YYYY")
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        ChangeSort(){
          if(this.Sort == 'asc'){
            this.Sort = 'desc'
          } else {
            this.Sort = 'asc'
          }
        this.GetTran()
      },
      GetTran(page){

            axios.post(`api/transection?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}`,{
                month_type: this.month_type,
                dmy:this.dmy
            },{ headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{
                this.TransectionData = res.data
            }).catch((error)=>{
                if(error){
                    if(error.response.status == 401){
                    this.store.remove_token()
                    this.store.remove_user()
                    localStorage.removeItem("web_token")
                    localStorage.removeItem("web_user")
                    this.$router.push("/login")
                    }
                }
            })

      }

    },
    created(){
        this.GetTran(1)
    },
    watch:{
        dmy(){
            this.GetTran()
        },
        month_type(){
            this.GetTran()
        }
    }
}
</script>
<style lang="">
    
</style>