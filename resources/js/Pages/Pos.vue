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
                    <input type="text" class="form-control mb-1" v-model="customer_name" placeholder="...">
                    <label> ເບີໂທ: </label>
                    <input type="text" class="form-control" v-model="customer_tel" placeholder="...">
                    <hr>
                    <div class=" d-flex justify-content-between text-info fs-5 fw-bold">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                    </div>
                    <button type="button" class="btn rounded-pill btn-info w-100" :disabled="!TotalAmount" @click="Pay()" >ຊຳລ່ະເງິນ</button>
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

    <div class="modal fade" id="dialog_pay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">ການຊຳລ່ະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class=" d-flex justify-content-between">
                    <span>ລວມຍອດເງິນ:</span>
                    <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                  </div>
                  <div class=" d-flex justify-content-between">
                    <span>ຮັບເງິນນຳລູກຄ້າ:</span>
                    <span>{{ formatPrice(CashAmount) }} ກີບ</span>
                  </div>
                  <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-TotalAmount)>0">
                    <span>ເງິນທອນ:</span>
                    <span>{{ formatPrice(CashAmount - TotalAmount) }} ກີບ</span>
                  </div>

                  <div class=" d-flex justify-content-center">
                    <div class="row" style=" width: 250px; ">
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('1')" >1</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('2')" >2</button>
                </div>
                <div class=" col-md-4 mt-2"> 
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('3')" >3</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('4')" >4</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('5')" >5</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('6')" >6</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('7')" >7</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('8')" >8</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('9')" >9</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('00')" >00</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('0')" >0</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-danger" style=" width: 60px;" @click="AddNum('-')" ><i class='bx bx-left-arrow-alt'></i></button>
                </div>


            </div>
                  </div>

                </div>
                <div class="modal-footer">
                  
                  <button type="button" class="btn btn-primary" @click="ConfirmPay()" :disabled="!(CashAmount>=TotalAmount)">ຍືນຍັນຊຳລ່ະເງິນ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
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
            Search:'',
            CashAmount:0,
            customer_name:'',
            customer_tel:''
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
        Pay(){
            this.CashAmount = 0
            $("#dialog_pay").modal("show")
        },
        async openLink(link){
            const response = await fetch(`${link}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}});
            const html = await response.text();
            const blob = new Blob([html],{ type: "text/html"});
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl, "_blank");
        },
        ConfirmPay(){

            axios.post(`api/transection/add`,{
                customer_name: this.customer_name,
                customer_tel: this.customer_tel,
                listorder: this.ListOrder
            },{ headers:{ Authorization: 'Bearer '+this.store.get_token } }).then((res)=>{
                if(res.data.success){

                    this.customer_name = ''
                    this.customer_tel = ''
                    this.ListOrder = []
                    this.CashAmount = 0
                    $("#dialog_pay").modal("hide")

                    // window.open(window.location.origin+'/api/bills/print/'+res.data.bill_id, "_blank")
                    this.openLink(window.location.origin+'/api/bills/print/'+res.data.bill_id)

                    // ອັບເດດລາຍການຂໍ້ມູນ
                    this.GetStore()

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
        },
        AddNum(num){
            if(num == '-'){
                this.CashAmount = this.CashAmount.slice(0,-1); // ລົບຈາກຂວາມື ຕົວຢ່າງ:  120 = 12
            } else {
                this.CashAmount = this.CashAmount + num; // 1 + 2 = 12 Not 3
            }
        },
        AddProduct(id){
            // console.log(id)
            let item = this.StoreData.data.find((i)=>i.id == id)
            let old_item = this.ListOrder.find((i)=>i.id == id)

            if(item.amount>0){

                    if(old_item){
                        if((item.amount - old_item.order_amount)>0){
                            old_item.order_amount++;
                        } else {
                            /// ສິນຄ້າໝົດໃນສະຕ໋ອກ
                            this.$swal({
                                title: "ບໍ່ສາມາດຂາຍໄດ້!",
                                text:"ສິນຄ້າດັ່ງກ່າວໄດ້ໝົດແລ້ວ!",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 3500
                                });
                        }
                        

                    } else {
                        this.ListOrder.push({
                        id: item.id,
                        name: item.name,
                        order_amount: 1,
                        price_sell: item.price_sell
                    })
                    }

        } else {
                /// ສິນຄ້າໝົດໃນສະຕ໋ອກ
                this.$swal({
                        title: "ບໍ່ສາມາດຂາຍໄດ້!",
                        text:"ສິນຄ້າດັ່ງກ່າວໄດ້ໝົດແລ້ວ!",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3500
                        });
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