<template>
<div>
    <div style="margin-bottom: 8vmin">
        <AppNavBar />
    </div>
    <router-view></router-view>

</div>

</template>

<style scoped>

</style>
<script>
import AppNavBar from "./AppNavBar";
import SideBar from "./SideBar";
import ContentComponent from "./Content";
export default {

    components: {
        AppNavBar,
        SideBar,
        ContentComponent
    }
}
</script>
