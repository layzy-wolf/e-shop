<script setup>
let basket = JSON.parse(localStorage.getItem("basket"))
</script>

<template>
    <div class="position-absolute basket bg-white">
        <div class="row py-2 px-0" v-for="product of basket">
            <img class="col-6 px-0" :src="product.img" alt="img" width="150">
            <div class="col-6">
                <h5 class="pr-100">{{ product.name }}</h5>
                <div class="pt-100 d-flex justify-content-between">
                    <h5>{{ product.amount }}</h5>
                    <h5>{{ product.price }}</h5>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.basket {
    z-index: 1;
}

.pr-100 {
    padding-right: 100%;
}

.pt-100 {
    padding-top: 25%;
}
</style>
