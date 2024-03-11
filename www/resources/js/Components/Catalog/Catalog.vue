<template>
    <ProductModal v-if="detail !== null" :getDetail="getDetail" :setDetail="setDetail" />
    <Carousel/>
    <div class="container d-flex gap-5 mt-3">
        <ProductCard v-for="product in products" :product="product" :showModal="showModal"/>
    </div>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import Carousel from "./Carousel.vue";
import ProductCard from "./ProductCard.vue";
import ProductModal from "./ProductModal.vue";

const products = ref([])
const loading = ref(true)
const detail = ref(null)


function showModal(ev) {
    detail.value = ev.target.dataset.productid
}

onMounted(async () => {
    products.value = await axios.get("/api/product")
        .then(res => {
            return res.data
        })
})

watch(products, async (newProducts) => {
    if (newProducts.length > 0) {
        loading.value = false
    }
})

watch(detail, async  (newId) => {
    detail.value = newId
})

function getDetail() {
    return detail.value
}
function setDetail(value) {
    detail.value = value
}

</script>
