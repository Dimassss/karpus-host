<template>
    <v-navigation-drawer
        v-model="showSidebar"
        fixed
        top
        right
        class="sidebar"
        width=""
        overlay-opacity="rgba(0,0,0,0)"
    >
        <template #prepend>
            <a
                href="#begin"
                @click="showSidebar = false"
            >
                <v-img
                    :lazy-src="imgs.logo.src"
                    :alt="imgs.logo.alt"
                    :src="imgs.logo.src"
                    class="logo"
                ></v-img>
            </a>

            <h1
                @click="handleClickOnH1"
                class="header"
            >{{text.header}}</h1>
        </template>

        <v-list>
            <v-list-item-group
                color="primary"
                flat
                v-model="scrollPos"
            >
                <v-list-item
                    v-for="link in menu"
                    :key="link.title"
                    color="#fff"
                    :href="link.href"
                    @click="showSidebar = false"
                >
                    <v-list-item-content>
                        <v-list-item-title v-text="link.title"></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>

        <template #append>
            <v-container class="footer">
                <v-row justify="space-around" align="center">
                    <v-col
                        cols="1"
                        v-for="item in socialMedia"
                        :key="item.href"
                    >
                        <a :href="item.href">
                            <i :class="`${item.icon}`" aria-hidden="true"></i>
                        </a>
                    </v-col>
                </v-row>
            </v-container>
        </template>

    </v-navigation-drawer>
</template>

<script>
export default {
    props: {
        show: {
            default: false
        }
    },
    data () {
      return {
        imgs: {
            logo:{
                src: 'media/images/logo.png',
                alt: 'Alt'
            }
        },
        text: {
            header: 'Ферма Карпусь'
        },
        menu: [
          { title: 'Щиро вітаємо', href: '#main' },
          { title: 'Про нас', href: '#family' },
          { title: 'Що ми вирощуємо', href: '#what-we-grow' },
          { title: 'Дізнатися більше', href: '#get-more-info' },
        ],
        scrollPos: 0,
        socialMedia: [
            {
                href: 'https://www.facebook.com/karpus.farm/',
                icon: 'fab fa-facebook'
            },
            {
                href: 'https://www.instagram.com/karpusfarm/?hl=ru',
                icon: 'fab fa-instagram'
            },
            {
                href: 'https://invite.viber.com/?g2=AQB5rEPr%2Fx0DH0xPBop0Tw8QGjzGDHkrtQvErKFNEdVJ%2FfRns%2F%2BDsZm%2FQs%2BzjoUN',
                icon: 'fab fa-viber'
            }
        ]
      }
    },
    computed: {
        showSidebar:{
            get(){
                const brPnt = this.$vuetify.breakpoint.name;
                const brPnts = ['xs', 'sm', 'md', 'lg', 'xl'];

                return brPnts.indexOf(brPnt) > 2 || this.show;
            },
            set(val){
                this.$emit('toggle-sidebar', val);
            }
        }
    },
    methods: {
        handleScroll(){
            let scrollPos = +this.menu.map((item, i) => [document.querySelector(item.href).getBoundingClientRect().top, i])
                    .filter(el => el[0] <= 100)
                    .map(el => el[1])
                    .slice(-1)[0];

            scrollPos = isNaN(+scrollPos) ? 0 : +scrollPos;

            if(this.scrollPos != scrollPos) this.scrollPos = scrollPos;
        },
        handleClickOnH1(){
            this.showSidebar = false;
            window.scrollTo(0,0);
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
    destroyed(){
        window.removeEventListener('scroll', this.handleScroll);
    }
  }
</script>

<style lang="scss" scoped>
.sidebar {
    width: min(405px, 80%);
    background-color: #298CCF;

    .logo{
        margin-top: .3rem;
    }

    .header {
        color: #fff;
        width: 100%;
        text-align: center;
        margin-top: .2rem;
        font-size: 2rem;
    }

    .v-list-item {
        text-align: center;
        color: white !important;
        border-bottom: 2px solid white;

        &:last-child{
            border: 0;
        }
    }

    .v-list-item:not(.v-list-item--active):not(.v-list-item--disabled):not(.v-item--active){
        color: white !important;
    }

    .v-item--active {
        color: #298CCF !important;
        background: white;
    }

    .footer{
        font-size: 2rem;

        i{
            color: white;
        }
    }
}
</style>
