<template>
    <v-app id="begin">
        <v-app-bar
            fixed
            dark
            class="d-lg-none"
        >
            <v-app-bar-nav-icon @click="showSidebar = !showSidebar" color="#ddd"></v-app-bar-nav-icon>

            <v-toolbar-title><a href="#begin" style="text-decoration: none; color: #0074d9">Ферма Карпусь</a></v-toolbar-title>
        </v-app-bar>

        <div class="content" :style="{paddingRight: paddingRight}">
            <LogoMainPage/>

            <slot></slot>
        </div>

        <Sidebar :show="showSidebar" @toggle-sidebar="val => showSidebar = val"/>
    </v-app>
</template>

<script>
import Sidebar from '../components/mainpage/Sidebar';
import LogoMainPage from '../components/mainpage/LogoMainPage';

export default {
    components:{
        Sidebar,
        LogoMainPage
    },
    data () {
        return {
            showSidebar: false
        }
    },
    computed: {
        paddingRight(){
            const brPnt = this.$vuetify.breakpoint.name;
            const brPnts = ['xs', 'sm', 'md', 'lg', 'xl'];
            const isOnPC = brPnts.indexOf(brPnt) > 2 || this.show;
            return isOnPC ? '405px' : '0';
        }
    }
}
</script>

<style lang="scss" scoped>
.content {
    width: 100%;
}
</style>
