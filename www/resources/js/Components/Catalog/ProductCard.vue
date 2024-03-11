<script setup>
let props = defineProps(["product", "showModal"])
</script>

<template>
    <div class="card w-25" aria-hidden="true" v-if="product !== null">
        <img :src="product.img" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title placeholder-glow">
                <span class="col-6">{{ product.name }}</span>
            </h5>
            <p class="card-text placeholder-glow">
                <span class="col-7">{{ product.category_name }}</span>
            </p>
            <button class="btn btn-primary col-6" :data-productId="product.id" @click="showModal">Просмотреть</button>
        </div>
    </div>
    <div class="card w-25" aria-hidden="true" v-else>
        <img src="@/Assets/img/placeholder.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title placeholder-glow">
                <span class="placeholder col-6"></span>
            </h5>
            <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
            </p>
            <a class="btn btn-primary disabled placeholder col-6"></a>
        </div>
    </div>
</template>
