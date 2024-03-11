<script setup>

</script>

<template>
    <form class="d-grid gap-3 position-absolute form-control w-100">
        <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
        <div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingText" placeholder="name">
                <label for="floatingText">Name</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    </form>
</template>

<style scoped>
.form-control {
    z-index: 1;
}
</style>
