<template>
    <div class="section_app">
        <div class="section_one box " :class="{'active': isAddClass}" :data-theme="theme">
            <button class="btn box-btn " v-if="!flug" @click="pressMe()">Press me</button>
            <div class="poper"></div>
            <div v-show="flug" class="div" :class="{'active': isAddClass}" >
                <div class="calc">
                    <form action="" :class="{'deactive': isAddClass}" class="calc__form form">
                        <div class="d-grid">
                            <div class="form__group">
                                <label for="sum" class="form__label">Сумма к выводу</label>
                                <div class="form__currency" :class="{'error':newPriceError}">
                                    <input
                                            class="form__input"
                                            id="sum"
                                            v-model="newPrice"
                                            @input="api=true"
                                            @keyup="getCryptApi"
                                    >
                                </div>
                            </div>
                            <div class="form__group">
                                <label for="currency" class="form__label">Валюта</label>

                                <select name="" id="currency" class="form__select styler " @change="getApi" v-model="selectedUp">
                                    <option
                                        v-for="(currency,index) in currencies"
                                        :key="index"
                                        v-model="currency.value"
                                    > {{ currency.text }}
                                    </option>
                                </select>
                            </div>
                            <div class="form__group">
                                <label for="commission" class="form__label">Наша комиссия</label>
                                <div class="form__currency">
                                    <input
                                            disabled
                                            class="form__input"
                                            id="commission"
                                            v-model="firstSumDiscount">
                                </div>
                            </div>
                            <div class="form__group">
                                <label for="sum1" class="form__label">Мы отправляем</label>
                                <div class="form__currency">
                                    <input
                                            disabled
                                            class="form__input"
                                            id="sum1"
                                            v-model="cryptTotal"
                                    >
                                </div>
                            </div>
                            <div class="form__group">
                                <label for="currency1" class="form__label">Криптовалюта</label>
                                <select name="" id="currency1" class="form__select styler" @change="getApi" v-model="selectedDown">
                                    <option
                                        v-for="(currency,index) in cryptCurrencies"
                                        :key="index"
                                        v-model="currency.value"
                                    > {{ currency.text }}
                                    </option>
                                </select>
                            </div>
                            <div class="form__group">
                                <label for="commission1" class="form__label">Вы получаете</label>
                                <div class="form__currency">
                                    <input
                                            class="form__input"
                                           id="commission1"
                                           @input="api=false"
                                           @keyup="getCurrencyApi"
                                            v-model="finalTotal">
                                </div>
                            </div>
                        </div>

                    </form>
                   
                </div>
            </div>



        </div>
        <div v-show="flug" class="block" :class="{'block_active': goBackEnd}">
            <button v-if="!goBackEnd" class=" btnAnimation" @click="animation()">Press me</button>

            <button class="btn-back" @click="start()">Go back</button>
        </div>

        <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" @change="switchTheme()"    />
                <div class="slider round"></div>
            </label>
        </div>
    </div>


</template>

<script>

import axios from 'axios';
import gsap from "gsap";

export default {
    components: {
        axios, gsap
    },
    data() {
        return {
            flug: false,
            isAddClass: false,
            newPriceError:false,
            theme:'light',
            root: null,
            cryptTotal: '',
            newPrice: '',
            api:false,
            firstSumDiscount:'',
            finalTotal:'',
            selectedUp: 'EUR',
            selectedDown: 'BTC',
            oldValue:'',
            currency:'',
            goBackEnd:false,
            currencies:[
                { text: 'EUR', value: 'EUR', symbol : '€' },
                { text: 'USD', value: 'USD', symbol : '$' },
                { text: 'GBP', value: 'GBP', symbol : '£' },
            ],
            cryptCurrencies:[
                { text: 'BTC', value: 'BTC', symbol : 'BTC' },
            ]
        }
    },
    computed: {
        inputSymbol() {
            let symbol = null;
            this.currencies.map(val => {
                if (val.value === this.selectedUp) {
                    symbol = val.symbol;
                }
            });

            return symbol;
        },
        cryptSymbol() {
            let symbol = null;
            this.cryptCurrencies.map(val => {
                if (val.value === this.selectedDown) {
                    symbol = val.symbol;
                }
            });

            return symbol;
        },

    },
    methods: {
        getCurrencyApi() {
            let upSelect = this.selectedUp.toLowerCase();
            let downSelect = this.selectedDown.toLowerCase();
            if (this.finalTotal.length > 0) {
                return fetch('https://api.cryptonator.com/api/ticker/' + downSelect + '-' + upSelect).then((res) => {
                    return res.json();
                }).then((data) => {
                    this.newPrice = this.inputSymbol + (parseFloat(this.finalTotal) * data.ticker.price).toString()  ;
                    this.firstSumDiscount = this.inputSymbol + ((this.newPrice.substr(1) * 4.5) / 100) ;
                    this.cryptTotal =this.inputSymbol + (this.newPrice.substr(1) - this.firstSumDiscount.substr(1)).toString()
                })
            }
        },
        getCryptApi() {
            console.log(this.newPrice);

            this.symbols = this.selectedUp;
            let upSelect = this.selectedUp.toLowerCase();
            let downSelect = this.selectedDown.toLowerCase();
            if (this.newPrice.length > 0) {
                let total = this.discount(this.newPrice.includes(this.inputSymbol)? this.newPrice.substr(1) : this.newPrice);
                this.newPriceError = false;
                return fetch('https://api.cryptonator.com/api/ticker/' + upSelect + '-' + downSelect).then((res) => {
                    return res.json();
                }).then((data) => {
                    this.finalTotal = (total.substr(1) * data.ticker.price).toString() + this.cryptSymbol ;

                })
            }
        },
        getApi() {
            if (this.api === false) {
                this.finalTotal = (!/^[0-9]+$/.test(this.finalTotal) ? parseFloat(this.finalTotal) : this.finalTotal).toString() + this.cryptSymbol;
                this.getCurrencyApi();
            }
            if (this.api === true) {
                this.newPrice = this.inputSymbol + (!/^[0-9]+$/.test(this.newPrice) ? this.newPrice.substr(1) : this.newPrice ).toString()
                this.getCryptApi();
            }
        },
        discount(newPrice) {
            this.firstSumDiscount = this.inputSymbol + ((newPrice * 4.5) / 100).toString() ;
            console.log(this.firstSumDiscount);
            this.cryptTotal = this.inputSymbol + (newPrice - this.firstSumDiscount.substr(1)).toString();
            return this.cryptTotal;
        },
        pressMe() {
            const box = document.querySelector('.box');
            const boxBtn = document.querySelector('.box-btn');
            const calcForm = document.querySelector('.calc__form');
            const block = document.querySelector('.block');
            const btnAnimation = document.querySelector('.btnAnimation');
            let $work = gsap.timeline();
            this.goBackEnd = false
            $work.to(box, {
                duration: 1,
                width: '100px',
                height: '100px',
                opacity: 1,
                borderRadius: '50%',
                ease: 'bounce.out',
            }) ;

            $work.to(boxBtn, {
                duration: 1,
                opacity: 0,
                fontSize: '0px',
                ease: 'bounce.out'
            }, '-=2');
            if (!this.flug) {
                this.flug = true;
                $work.to(box, {
                    duration: 1,
                    width: '720px',
                    height: '277px',
                    opacity: 1,
                    borderRadius: '15px',
                    ease: 'bounce.out'
                }).from(calcForm, {
                    duration: 1,
                    opacity: 0
                }).from(block, {
                    duration: 1,
                    opacity: 0,
                    bottom:-100,
                    ease: 'bounce.out'
                },'-=2')
            } else {
                this.flug = false;
            }
            if (!this.goBackEnd ){
                $work.to(block, {
                    opacity:1
                })
            }
        },
        animation() {
            if(this.newPrice != ''){
                const btnAnimation = document.querySelector('.btnAnimation');
                const section_one = document.querySelector('.section_one ');
                const box = document.querySelector('.box.active');
                const btnBack = document.querySelector('.btn-back');
                const calcForm = document.querySelector('.calc__form');
                const block = document.querySelector('.block');
                const poper = document.querySelector('.poper');
                const div = document.querySelector('.div');
                let $work = gsap.timeline();
                this.isAddClass = true;
                $work.to(div, {
                    opacity:0,
                    duration: 0
                });

                $work.from(calcForm, {
                    opacity: 1,
                    duration: .1
                }).to(calcForm, {
                    opacity: 1,
                    duration: 1
                });

                $work.to(poper, {
                    duration: 2,
                    x: "60vw",
                    y:"-30vh",
                    z:600,
                    rotate:60,
                    scale:0.4
                })

                $work.to(btnBack, {
                    duration: 1,
                    y:"-30vh",
                });

                if (!this.goBackEnd ){

                }
                this.goBackEnd = true
                this.newPrice = ''
                this.cryptTotal = ''
                this.firstSumDiscount = ''
                this.finalTotal = ''

            }else{
                this.newPriceError = true;
            }

        },
        start() {
            const box = document.querySelector('.box');
            const boxBtn = document.querySelector('.box-btn');
            const btnAnimation = document.querySelector('.btnAnimation');
            const block = document.querySelector('.block');
            const div = document.querySelector('.div');
            const poper = document.querySelector('.poper');
            const btnBack = document.querySelector('.btn-back');
            gsap.to(box, {
                duration: 1,
                width: '430px',
                height: '120px',
                opacity: 1,
            })
            gsap.from(boxBtn, {
                duration: 1,
                opacity: 0,
                fontSize: '0px',
            }, '-=2')
            if (this.goBackEnd ){
                gsap.from(block, {
                    bottom:"-100px",
                    opacity:0
                })
                gsap.to(div, {
                    opacity:1
                });

                gsap.to(poper, {
                    duration: 1,
                    x: 0,
                    y:0,
                    z:0,
                    rotate:0,
                    scale:1
                });
                gsap.to(btnBack, {
                    duration: 0,
                    y:"0",
                });
                this.flug = false
            }
            this.isAddClass = false;
            this.flug = false;
        },
        switchTheme(){
            if(  this.theme != 'dark' ){
                localStorage.theme = 'dark'
                this.theme = 'dark'
                document.body.setAttribute('data-theme', this.theme);
            }else{
                localStorage.theme = 'light'
                this.theme = 'light'
                document.body.setAttribute('data-theme', this.theme);
            }
        }
    },
    mounted() {
        const box = document.querySelector('.box');
        const boxBtn = document.querySelector('.box-btn');
        if (localStorage.theme) {
            this.theme = localStorage.theme
            document.body.setAttribute('data-theme', this.theme);
            if(this.theme == 'dark'){
                document.getElementById('checkbox').checked = true;
            }
        }
        gsap.from(box, {
            duration: 1,
            width: 0,
            height: 0,
            opacity: 0,
            ease: 'bounce.out'
        })
        gsap.from(boxBtn, {
            duration: 1,
            opacity: 0,
            fontSize: '0px',
            ease: 'bounce.out'

        }, '-=2')

    },
}
</script>
