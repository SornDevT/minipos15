<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <input type="text" class="form-control" v-model="Search" placeholder="ຄົ້ນຫາ..." @keyup.enter="GetStore()">
                </div>
            </div>
            <PerfectScrollbar>
            <div class="m-1" style="height:65vh;">
                <div class="row " >
                    <div class="col-md-3 mb-3" v-for=" item in StoreData.data" :key="item.id">
                        <div class="card h-100 cursor-pointer" @click="AddProduct(item.id)">
                                <spa v-for="i in ListOrder" :key="i.id"> 
                                    <span class="num-p" v-if="item.id == i.id">{{ i.order_amount }}</span>
                                </spa>
                            <img class="img-pos" v-if="item.image" :src="url + '/assets/img/'+item.image" alt="Card image cap">
                            <img class="img-pos" v-else :src="url + '/assets/img/no_image.png'" alt="Card image cap">
                            <div class="card-body p-1 text-center">
                                <h5 class="card-title">{{item.name}}</h5>
                                <p class="card-text">
                                {{formatPrice(item.price_sell)}} kip
                                </p>
                            
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            </PerfectScrollbar>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <label> ຊື່ລູກຄ້າ: </label>
                    <input type="text" class="form-control mb-1" placeholder="...">
                    <label> ເບີໂທ: </label>
                    <input type="text" class="form-control" placeholder="...">
                    <hr>
                    <div class=" d-flex justify-content-between text-info fs-5 fw-bold">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                    </div>
                    <button type="button" class="btn rounded-pill btn-info w-100" :disabled="!TotalAmount" >ຊຳລ່ະເງິນ</button>
                    <PerfectScrollbar>
                        <!-- {{ListOrder}} -->
                    <div class="mt-2" style="height:43vh">
                        <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ລາຍລະອຽດ</th>
                                <th>ລາຄາ</th>
                                <th>ລາຄາລວມ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr  v-for="list in ListOrder" :key="list.id">
                                <td>{{ list.name }}</td>
                                <td class="text-end">{{ formatPrice(list.price_sell) }}<br>
                                    <i class='bx bxs-no-entry text-warning cursor-pointer' @click="RemoveProduct(list.id)"></i>  {{list.order_amount}} <i class='bx bxs-plus-circle text-info cursor-pointer' @click="AddProduct(list.id)"></i> | <i class='bx bxs-x-circle text-danger cursor-pointer' @click="DeleteProduct(list.id)"></i>
                                </td >
                                <td class="text-end">{{ formatPrice(list.price_sell*list.order_amount) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </PerfectScrollbar>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { useStore } from '../Store/auth'
export default {
    setup(){
        const store = useStore()
        return { store }
    },
    data() {
        return {
            url: window.location.origin,
            StoreData:[],
            ListOrder:[],
            Sort:'desc',
            PerPage:'20',
            Search:''
        }
    },
    computed:{
        TotalAmount(){
            let calculate = this.ListOrder.reduce((num , item)=> parseInt(num) + (parseInt(item.order_amount)*parseInt(item.price_sell)),0)
            return calculate
        }
    },
    methods: {
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        AddProduct(id){
            // console.log(id)
            let item = this.StoreData.data.find((i)=>i.id == id)
            let old_item = this.ListOrder.find((i)=>i.id == id)

            if(old_item){
                old_item.order_amount++;
            } else {
                this.ListOrder.push({
                id: item.id,
                name: item.name,
                order_amount: 1,
                price_sell: item.price_sell
            })
            }
        },
        RemoveProduct(id){
            let item = this.ListOrder.find((i)=>i.id == id)
            if(item){
                item.order_amount--;
                if(item.order_amount<1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>id).indexOf(id),1)
                }
            }
        },
        DeleteProduct(id){
            this.ListOrder.splice(this.ListOrder.map((i)=>id).indexOf(id),1)
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
        this.GetStore()
    },
    watch:{
        Search(){
            if(this.Search == ''){
                this.GetStore()
            }
        }
    }
}
</script>
<style  scoped>
    .img-pos{
        object-fit: cover;
    height: 110px;
    width: 100%;
    object-position: center;
    }
    .num-p{
        position: absolute;
    background-color: orangered;
    color: white;
    padding: 5px;
    right: 0px;
    border-radius: 0px 10px;
    }
</style>