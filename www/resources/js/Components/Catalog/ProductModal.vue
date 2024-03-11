<script setup>
import {onMounted, ref} from "vue";

let props = defineProps(["getDetail", "setDetail"])

const product = ref([]);

onMounted(async () => {
    await axios.get("/api/product/" + props.getDetail() + '/detail')
        .then((res) => {
            product.value = res.data
        })
})

function closeModal() {
    props.setDetail(null)
}

function basketAdd(product) {
    let basket = localStorage.getItem("basket")
    let amount = 1
    let price = product.price
    if (basket === null) {
        basket = []
    } else {
        basket = JSON.parse(basket)
        for (let prod of basket) {
            if (prod.id === product.id) {
                amount = prod.amount + amount
                price = prod.price * amount
                basket.splice(basket.indexOf(prod), 1)
            }
        }
    }
    basket.push({id: product.id, name: product.name, img: product.img, amount: amount, price: price})
    localStorage.setItem("basket", JSON.stringify(basket))
    closeModal()
}

</script>

<template>
    <div class="modal modal-sheet position-absolute d-block bg-body-secondary px-4 pt-5" tabindex="-1" role="dialog"
         id="modalSheet">
        <div class="modal-dialog modal-lg opacity-100" role="document">
            <div class="modal-content rounded-4 shadow w-100 opacity-100">
                <div class="modal-header border-bottom-0">
                    <h1 class="modal-title fs-5">{{ product.name }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="closeModal"></button>
                </div>
                <div class="modal-body py-2 px-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <img class="m-100" :src="product.img" alt="img" width="300">
                        </div>
                        <div class="col-sm-6">
                            <h5> Description:
                                {{ product.description }}
                            </h5>
                            <h5>Category: {{ product.category_name }}</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <h5>Price: {{product.price}}</h5>
                    <button class="btn btn-success" @click="basketAdd(product)"><i class="fa-solid fa-cart-shopping"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-body-secondary {
    background: rgba(0, 0, 0, 0.5);
}
</style>
