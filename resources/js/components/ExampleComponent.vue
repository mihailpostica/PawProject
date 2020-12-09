<template>
    <div class="container d-flex h-100 flex-column">
        <div class="flex-grow-1"></div>
        <div class="row justify-content-center">
            <div class="col-3">
                <div class="card">ITEM A</div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-3">
                <div class="card">ITEM B</div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-3">
                <div class="card">ITEM C</div>
            </div>
        </div>
        <div class="flex-grow-1"></div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
