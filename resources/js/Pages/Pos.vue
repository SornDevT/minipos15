<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <input type="text" class="form-control" placeholder="ຄົ້ນຫາ...">
                </div>
            </div>
            <PerfectScrollbar>
            <div class="m-1" style="height:65vh;">
                <div class="row " >
                    <div class="col-md-3 mb-3" v-for=" item in 30" :key="item">
                        <div class="card h-100">
                            <img class="card-img-top" src="assets/img/elements/2.jpg" alt="Card image cap">
                            <div class="card-body p-1 text-center">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                150.000 kip
                                </p>
                            
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            </PerfectScrollbar>

        </div>
        <div class="col-md-4">B</div>
    </div>
</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>