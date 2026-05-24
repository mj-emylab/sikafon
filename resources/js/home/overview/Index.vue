<template>
    <div class="" style="padding-top: 30vh;">

        <div class="d-flex mx-auto justify-content-center">
            <input style="text-align: center;" v-model="amount" placeholder="amount"  type="text" class="text-primary" />
        </div>


            
        <div class="d-flex mx-auto justify-content-center">
            <button style="margin-right: 10px;" @click.prevent="deposit()" type="button" class="btn btn-danger mt-2 mr-1">
                <i class="fa fa-plus"></i>
                Deposit
            </button>
            <button style="margin-right: 10px;" @click.prevent="createAccount()" type="button" class="btn btn-danger mt-2 mr-1">
                Create Acct
            </button>
            <button style="margin-right: 10px;" @click.prevent="withdraw()" type="button" class="btn btn-danger mt-2">
                <i class="fa fa-minus"></i>
                Withdraw
            </button>

            <button style="" @click.prevent="getAccount()" type="button" class="btn btn-danger mt-2">
                get Acct
            </button>
        </div>

        <div class="d-flex mx-auto justify-content-center">

            <button style="margin-right: 10px;" @click.prevent="getTransaction()" type="button" class="btn btn-danger mt-2">
                get Transaction
            </button>

            <button style="margin-right: 10px;" @click.prevent="getAccountBalance()" type="button" class="btn btn-danger mt-2">
                get Balance
            </button>

            <button style="" @click.prevent="selfTransfer()" type="button" class="btn btn-danger mt-2">
                self Transfer
            </button>
                
                
        </div>

    </div>
</template>

<script>

    import helper from '../../helpers/helpers.js';
    const axios = require('axios').default;

  export default {
    components: {
    },
    data() {
        return {

            isLoading: false,
            amount: '0.00',
        }
    },
    methods: {

        

        async deposit(){
            try {
                const data = {
                    amount: this.amount,
                };
                axios
                .post('http://127.0.0.1:8001/api/deposit_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async createAccount(){
            try {
                const data = {
                    phone: '0557522685',
                };
                axios
                .post('http://127.0.0.1:8001/api/create_account_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async withdraw(){
            try {
                const data = {
                    amount: this.account,
                };
                axios
                .post('http://127.0.0.1:8001/api/withdrawal_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async getAccount(){
            try {
                const data = {
                    amount: this.amount,
                };
                axios
                .post('http://127.0.0.1:8001/api/get_account_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async getAccountBalance(){
            try {
                const data = {
                    amount: this.amount,
                };
                axios
                .post('http://127.0.0.1:8001/api/get_account_balance_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async getTransaction(){
            try {
                const data = {
                    amount: this.amount,
                };
                axios
                .post('http://127.0.0.1:8001/api/get_transaction_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async selfTransfer(){
            try {
                const data = {
                    amount: this.amount,
                };
                axios
                .post('http://127.0.0.1:8001/api/self_transfer_gate', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        async testNG() {
            const response = await axios.get('http://127.0.0.1:8000/api/start_ngrok', {
                // headers: {
                //     Authorization: `Bearer ${this.token}`,
                // },
                params: {
                    constituency: 'JOMORO',
                    length: 50,
                    page: 1,
                },
            });
        },

        async addModal() {
            try {
                const data = {
                    msg: 'sms 1',

                    phone: '0557522685',
                };
                axios
                .post('https://nana-frimpomaa.com/register_voter2', data, 
                // { headers }
                )
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.error(error);
                });

            } catch (error) {
                console.error('Error:', error);
            }
        },

        
    },
    mounted() {
        
      
    },
    created() {

        
    },
    computed: {
        

        
    },

  }
</script>
<style scoped>
   

</style>
