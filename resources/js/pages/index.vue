<template>
  <Layout>
    <div class="content">
        <v-container>

            <v-row id="main" class="section">
                <v-col cols="12">
                    <h2 style="color: #298CCF">{{content.main.title}}</h2>

                    <p>{{content.main.text}}</p>
                </v-col>
            </v-row>

            <v-row id="family" class="section">
                <v-col cols="12">
                    <h2>{{content.family.title}}</h2>

                    <p>
                        {{content.family.text}}
                    </p>
                </v-col>
                <v-col
                    v-for="img in content.family.imgs"
                    :key="img"
                    cols="12"
                    md="4"
                >
                    <v-img
                        :lazy-src="img"
                        :src="img"
                        rounded
                    />
                </v-col>
            </v-row>

            <v-row id="what-we-grow" class="section">
                <v-col cols="12">
                    <h2>{{content.whatWeGrow.title}}</h2>

                    <p>
                        {{content.whatWeGrow.text}}
                    </p>
                </v-col>

                <v-col cols="12">
                    <v-container>
                        <v-row
                            v-for="card in content.whatWeGrow.cards"
                            :key="JSON.stringify(card)"
                            align="center"
                            class="card"
                        >
                            <v-col cols="12" md="5">
                                <v-img
                                    :lazy-src="card.img"
                                    :src="card.img"
                                />
                            </v-col>
                            <v-col cols="12" md="7">
                                <h2>{{card.title}}</h2>
                                <p>{{card.description}}</p>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-col>
            </v-row>

            <v-row id="delivery" class="section">
                <v-col cols="12">
                    <h2>{{content.delivery.title}}</h2>
                </v-col>
                <v-col cols="12" lg="5">
                    <v-img
                        :src="content.delivery.img"
                    />
                </v-col>
                <v-col cols="12" lg="7">
                    <p>
                        {{content.delivery.text}}
                    </p>
                </v-col>
            </v-row>

            <v-row id="get-more-info" class="section">
                <v-col cols="12">
                    <h2>{{content.getMoreInfo.title}}</h2>
                    <p>{{content.getMoreInfo.text}}</p>
                </v-col>

                <v-col cols="12">
                    <v-form
                        v-if="showForm"
                        ref="form"
                        v-model="valid"
                    >
                        <v-text-field
                            v-model="form.fields.name.value"
                            :counter="80"
                            :label="form.fields.name.label"
                            :rules="form.fields.name.rule"
                            required
                            class="input"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.fields.telephone.value"
                            :counter="15"
                            :rules="form.fields.telephone.rule"
                            :label="form.fields.telephone.label"
                            required
                            class="input"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.fields.email.value"
                            :counter="80"
                            :rules="form.fields.email.rule"
                            :label="form.fields.email.label"
                            required
                            class="input"
                        ></v-text-field>

                        <v-textarea
                            name="message"
                            :label="form.fields.message.label"
                            v-model="form.fields.message.value"
                            :rules="form.fields.message.rule"
                            required
                            class="input"
                        ></v-textarea>

                        <v-btn
                            :disabled="!valid"
                            color="primary"
                            class="mr-4"
                            @click="sendForm"
                        >
                            Відправити
                        </v-btn>
                    </v-form>
                    <v-alert v-else :type="formMessage.type">
                        {{formMessage.text}}
                    </v-alert>
                </v-col>

                <v-col
                    v-for="contact in content.getMoreInfo.contacts"
                    :key="JSON.stringify(contact)"
                    cols="12"
                    sm="6"
                    style="margin-top: 2rem; text-align: center"
                >
                    <p v-html="convertToHtml(contact.name)"></p> <br/>

                    <p>
                        <span
                            v-for="tel in contact.telephones"
                            :key="tel.value"
                        >
                            <a
                                v-if="tel.isLinked"
                                :href="`tel:+${tel.value.replace(/[\s-\+\(\)]/g, '')}`"
                                class="tel-link"
                            >
                                {{tel.value}}
                            </a>
                            <span v-else>{{tel.value}}</span>
                            <br/>
                        </span>
                        <span><a :href="`mailto:${contact.email}`">{{contact.email}}</a></span>
                    </p>
                </v-col>

                <v-col cols="12" style="margin-top: 1rem; text-align: center; word-break: keep-all;">
                    <p>{{content.getMoreInfo.adress}}</p>
                </v-col>

                <v-col cols="12">
                    <GoogleMap/>
                </v-col>
            </v-row>

        </v-container>
    </div>
  </Layout>
</template>

<script>
import Layout from '../layuots/default';
import GoogleMap from '../components/mainpage/GoogleMap';

const EMAIL_REGEX = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const TELEPHONE_REGEX = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

export default {
    components: {
        Layout,
        GoogleMap
    },
    computed: {},
    data() {
        return {
            valid: true,
            showForm: true,
            formMessage: {type: 'success', text: ''},
            form: {
                name: '',
                fields: {
                    name: {
                        value: '',
                        label: "Ваше ім'я",
                        rule: [
                            v => v.length > 1 || ''
//                            "Им'я занадто коротке"
                        ]
                    },
                    telephone: {
                        value: '',
                        rule: [
                            v => {
                                const m = v.match(/\d/g);
                                const r = v.replace(/[-\+\s\d\(\)]/g, '');

                                return (m && 10 <= m.length && m.length <= 15 && r.length == 0) || '';
//                                    'Невірний номер телефону (Приклад: +38 095 846 2853, 095-846-2853, 380958462853 ...)';
                            }
                        ],
                        label: "Ваш номер телефону"
                    },
                    email: {
                        value: '',
                        rule: [
                            v => EMAIL_REGEX.test(v.toLowerCase()) || ''
//                            'Невірний емейл. (my.email@gmail.com)'
                        ],
                        label: "Ваш email"
                    },
                    message: {
                        value: '',
                        label: 'Ваше повідомлення до ферми Карпусь',
                        rule: [
                            v => v.length > 30 || ''
//                            'Ваше повідомлення занадто коротке'
                        ]
                    },
                    '_csrf': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            },
            content: {
                main: {
                    title: 'Запрошуємо на ферму!',
                    text: `Карпусь - сімейне господарство, яке знаходиться в селі Маломихайлівка, рівно на півдорозі між Запоріжжям, Дніпром та Донецьком. Ми бережемо і поважаємо нашу землю, допомагаємо їй переважно натуральними добривами, компостом, а для захисту від шкідників використовуємо біопрепарати. Багато роботи виконується вручну нашими вмілими працівниками, а спілі овочі та зелень ми відвозимо прямо з грядки на місцеві ринки, в невеликі магазини і особисто сім’ям. Наша сім’я з 1985 року працює на родючій землі Дніпропетровщини і ми прагнемо, щоб і наші діти продовжували цю нелегку роботу з тією ж радістю та натхненням, як і ми, і щоб майбутні покоління завжди мали на столі смачну та здорову їжу.`
                },
                family: {
                    title: "Сім'я Карпусь",
                    text: `Подружжя Карпусь, Олександр та Олександра, живуть і працюють на фермі. Їхні діти приймають активну участь і підтримують батьків у нелегкій роботі на землі. Родичі та односельчани дбайливо ставляться до землі, щоденно піклуються та доглядають за рослинами у господарстві. Наша команда в місті Дніпро спілкується з клієнтами, організовує продаж і логістику, допомагає в розвитку ферми. Олександр Карпусь - голова сім’ї і землевласник у третьому поколінні, свою першу теплицю він побудував в 1985 році, в якій виріс його перший врожай огірків. В 2009 році сім’я Карпусь приймає рішення побудувати нові сучасні теплиці. Сучасні технології та методи вирощування дозволяють їм вирощувати овочі, трави і квіти цілий рік, щоб навіть в самі холодні місяці радувати городян свіжою зеленню.`,
                    imgs: [
                        '/media/images/family1.jpg',
                        '/media/images/service1.jpg',
                        '/media/images/managers1.jpg'
                    ]
                },
                whatWeGrow: {
                    title: 'Що ми вирощуємо',
                    text: `На фермі росте багато різновидів томатів (особливо кольорових чері), огірки, перець, листова капуста кейл, великий асортимент м'яти та пряних трав в горщиках. Частину теплиць ми відводимо для вирощування розсади овочів та квітів. Весною ферма розквітає яскравими кольорами пеларгонії, віоли, петунії та великим асортиментом квітів для клумб. Оскільки ми намагаємося підтримувати натуральні методи сільського господарства, наявність і вартість товарів залежить від сезону. Будь ласка, зв'яжіться з нами та дізнайтеся, що вродило і є в наявності для продажу.`,
                    cards: [
                        {
                            img: '/media/images/vegetables1.jpg',
                            title: 'Овочі',
                            description: 'Всі наші овочі ми вирощуємо в грунті у спеціальних високих теплицях, де багато сонця і повітря, тому вони виростають соковиті, з насиченим смаком.'
                        },
                        {
                            img: '/media/images/salad1.jpg',
                            title: 'Капуста кейл (kale)',
                            description: 'У світі капуста кейл набула великої популярності. Ми її вирощуємо, щоб ви також мали можливість насолоджуватися її смаком та користю.'
                        },
                        {
                            img: '/media/images/herbs1.jpg',
                            title: 'Пряні трави',
                            description: "Наші трави живі і ростуть в горщиках наповнених землею. М'ята, базилік, розмарин, тим'ян, орегано і шавлія - це справжні помічники на кухні."
                        },
                        {
                            img: '/media/images/flowers1.jpg',
                            title: 'Квіти',
                            description: 'Великий різновид живих квітів в горщиках можна замовити починаючи з середини зими. Наші квіти ростуть поряд з вами, вони свіжі, яскраві і наповнені життям.'
                        },
                        {
                            img: '/media/images/seedling1.jpg',
                            title: 'Розсада',
                            description: 'Наша розсада - сильна і витривала, а сорта вдало підібрані для нашого регіону. Це касетна розсада овочів та квітів, вона швидко зростає і дає гарний врожай.'
                        }
                    ]
                },
                delivery: {
                    title: 'Доставка',
                    text: `Ми відправляємо продукцію прямо з ферми сім’ям, офісам, ресторанам, еко-магазинам і супермаркетам. Раз на тиждень формуємо набори і доставляємо в місто Дніпро, а також відправляємо Новою Поштою по Україні. В місті Дніпро нашу продукцію можна купити в магазинах Еко-Лавка, Сільпо та Le Silpo. Весною ми приїжджаємо з квітами на центральні ринки нашого регіону: в Першотравенськ, Просяну, Чаплино, Васильківку, Межову, Покровськ, Гуляй Поле, Пологи та Оріхів.`,
                    img: '/media/images/transfer.jpg'
                },
                getMoreInfo: {
                    title: 'Дізнатися більше',
                    text: 'Напишіть нам або зателефонуйте.',
                    contacts: [
                        {
                            name: 'Карпусь\n Олександр і Олександра\n господарство',
                            telephones: [
                                {
                                    value: '+38 (097) 565-99-22',
                                    isLinked: true
                                },
                                {
                                    value: '(095) 062-54-44',
                                    isLinked: false
                                }
                            ],
                            email: 'farm@karpus.com.ua'
                        },
                        {
                            name: 'Балюра \n Олександр \n продажі',
                            telephones: [
                                {
                                    value: '+38 (067) 564-71-44',
                                    isLinked: false
                                },
                                {
                                    value: '(099) 601-08-08',
                                    isLinked: true
                                }
                            ],
                            email: 'sasha@karpus.com.ua'
                        }
                    ],
                    adress: 'Дніпропетровська обл. Покровський р-н с. Маломихайлівка вул. Гоголя, 18-а'
                }
            }
        }
    },
    methods: {
        sendForm(){
            const form = this.form.fields;
            const { name, telephone, email, message, _csrf } = form;
            const  formData = new FormData();

            formData.append('name', name.value);
            formData.append('telephone', telephone.value);
            formData.append('email', email.value);
            formData.append('message', message.value);
            formData.append('_token', _csrf);

            this.showForm = false;
            this.formMessage = {
                type: 'info',
                text: 'Форма відправляється'
            };

            fetch('/mainpage/send-form', {
                method: 'POST',
                body: formData
            }).then(response => {
                if(response.status != 200) throw response;
                return response;
            })
            .then(data => {

                const form = {
                    name: '',
                    fields: {
                        name: {
                            value: '',
                            label: "Ваше ім'я",
                            rule: [
                                v => v.length > 1 ||
                                "Им'я занадто коротке"
                            ]
                        },
                        telephone: {
                            value: '',
                            rule: [
                                v => TELEPHONE_REGEX.test(v.toLowerCase()) ||
                                'Невірний номер телефону (095 846 2853, 095.846.2853, 095-846-2853, 0958462853)'
                            ],
                            label: "Ваш номер телефону"
                        },
                        email: {
                            value: '',
                            rule: [
                                v => EMAIL_REGEX.test(v.toLowerCase()) ||
                                'Невірний емейл. (my.email@gmail.com)'
                            ],
                            label: "Ваш email"
                        },
                        message: {
                            value: '',
                            label: 'Ваше повідомлення до ферми Карпусь',
                            rule: [
                                v => v.length > 30 ||
                                'Ваше повідомлення занадто коротке'
                            ]
                        },
                        '_csrf': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                };

                this.form = form;
                this.formMessage = {
                    type: 'success',
                    text: "Форма відправлена, дякуємо! Ми зв'яжемося з Вами протягом 24 годин."
                };
            }).catch((err) => {
                console.log(err);
                this.formMessage = {
                    type: 'error',
                    text: 'Форма не відправилася. Напишіть нам пізніше.'
                };
            }).finally(() => {
                this.formMessage.text += ' Також можна перезагрузити сторінку, щоб ввести форму ще раз';
            })
        },
        convertToHtml(str){
            return str.split('\n').map(t => t+'<br/>').reduce((a,b) => a+b, '');
        }
    }
};
</script>

<style lang="scss" scoped>
.content {
    width: 100%;

    @media screen and (min-width: 960px){
        padding: 0 5rem;
    }
}

h2 {
    margin-bottom: 1rem;
    font-size: 2.5rem;
}

p{
    font-size: 1.1rem;
    color: #000;
}

.row.section {
    border-bottom: 6px solid #f4f4f4;
    padding: 4rem 0;
}

.v-image {
    border-radius: .5rem;
}

.card {
    box-shadow: 2px 1px 5px 0px rgba(50, 50, 50, 0.25);
    border-radius: .3rem;
    margin-bottom: 1rem;
}

.tel-link{
    text-decoration: none;
    color: #3c3c5c;

    &:hover, &:active{
        color: #4c4cfc;
    }
}

</style>

<style lang="scss">

.input{
    input, textarea {
        background: #f7f7f5;
        border-radius: 4px;
    }
}

</style>
