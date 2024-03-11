<script setup>
import Login from "./Login.vue";
import Register from "./Register.vue";
import {ref} from "vue";
import Basket from "./Basket.vue";

const loginOpen = ref(false)
const registerOpen = ref(false)
const basketOpen = ref(false)

function openLogin() {
    registerOpen.value = false
    basketOpen.value = false
    if (loginOpen.value) {
        loginOpen.value = false
        return
    }
    loginOpen.value = true
}

function openRegister() {
    loginOpen.value = false
    basketOpen.value = false
    if (registerOpen.value) {
        registerOpen.value = false
        return
    }
    registerOpen.value = true
}

function openBasket() {
    loginOpen.value = false
    registerOpen.value = false
    if (basketOpen.value) {
        basketOpen.value = false
        return
    }
    basketOpen.value = true
}

</script>

<template>
    <header class="d-flex py-2 m-0 border-bottom bg-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="col-md-3 mb-2 mb-md-0">
                <h5 class="text-white">Brand</h5>
            </div>

            <div class="d-flex gap-3 col-md-3 text-end position-relative">
                <div class="mr-1.5">
                    <button class="btn btn-success" @click="openBasket">
                        <span v-if="basketOpen">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                        <span v-else>
                            <i class="fa-solid fa-cart-shopping"></i>
                        </span></button>
                    <Basket v-if="basketOpen"/>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary me-2" @click="openLogin">
                        <span v-if="loginOpen">
                            <i class="fa-solid fa-xmark"></i>
                    </span>
                        <span v-else>Login</span>
                    </button>
                    <Login v-if="loginOpen"/>
                    <button type="button" class="btn btn-primary position-relative" @click="openRegister">
                        <span v-if="registerOpen">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                        <span v-else>Sign-up</span>
                    </button>
                    <Register v-if="registerOpen"/>
                </div>
            </div>
        </div>
    </header>
</template>
