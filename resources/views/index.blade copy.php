<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emjay</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div style="padding-top: 20vh;">
        <div class="d-flex mx-auto justify-content-center">
            <input style="text-align: center;" id="amount" placeholder="amount" type="text" class="text-primary" />
            <input style="text-align: center;" id="qr_code_image" placeholder="qr_code_image" type="file" class="text-primary" />
        </div>
        <br>
        <div class="d-flex mx-auto justify-content-center">
            <button style="margin-right: 10px;" onclick="deposit()" type="button" class="btn btn-danger mt-2 mr-1">
                <i class="fa fa-plus"></i> Deposit
            </button>
            <button style="margin-right: 10px;" onclick="createAccount()" type="button" class="btn btn-danger mt-2 mr-1">
                Create Acct
            </button>
            <button style="margin-right: 10px;" onclick="withdraw()" type="button" class="btn btn-danger mt-2">
                <i class="fa fa-minus"></i> Withdraw
            </button>
            <button onclick="getAccount()" type="button" class="btn btn-danger mt-2">
                get Acct
            </button>
        </div>
        <div class="d-flex mx-auto justify-content-center">
            <button style="margin-right: 10px;" onclick="getTransaction()" type="button" class="btn btn-danger mt-2">
                get Transaction
            </button>
            <button style="margin-right: 10px;" onclick="getAccountBalance()" type="button" class="btn btn-danger mt-2">
                get Balance
            </button>
            <button onclick="selfTransfer()" type="button" class="btn btn-danger mt-2">
                self Transfer
            </button>
        </div>


        <!--  -->
        <hr>
        <hr>
        <br>

        <div class="d-flex mx-auto justify-content-center">
            <button style="margin-right: 10px;" onclick="depositD()" type="button" class="btn btn-danger mt-2">
                Deposit
            </button>
            <button style="margin-right: 10px;" onclick="withdrawD()" type="button" class="btn btn-danger mt-2">
                withdraw
            </button>
            <button style="margin-right: 10px;" onclick="getTransactionD()" type="button" class="btn btn-danger mt-2">
                get Trans
            </button>
            <button style="margin-right: 10px;" onclick="give()" type="button" class="btn btn-danger mt-2">
                give
            </button>
            <button style="margin-right: 10px;" onclick="take()" type="button" class="btn btn-danger mt-2">
                take
            </button>
        </div>
        <div class="d-flex mx-auto justify-content-center">
            <button style="margin-right: 10px;" onclick="getAccountAgent()" type="button" class="btn btn-danger mt-2">
                get Acct Ag
            </button>
            <button style="margin-right: 10px;" onclick="selfTransferD()" type="button" class="btn btn-danger mt-2">
                self Transfer
            </button>
            <button style="margin-right: 10px;" onclick="newAcct()" type="button" class="btn btn-danger mt-2">
                New Acct
            </button>
            <button style="margin-right: 10px;" onclick="addAcct()" type="button" class="btn btn-danger mt-2">
                Add Acct
            </button>
            <button style="margin-right: 10px;" onclick="getCode()" type="button" class="btn btn-danger mt-2">
                Code
            </button>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        // Use relative paths if your API is on the same domain
        const apiUrl = '{{ url('api') }}';

        function verifyCode() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/verify_code', { 
                amount: '20.00',
                code: amount,
                trans_type: 2, 
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function depositD() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/transaction', { 
                amount: '20.00',
                code: amount,
                trans_type: 2, 
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function withdrawD() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/transaction', { 
                amount: '20.00',
                code: amount,
                trans_type: 1, 
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getTransactionD() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/get_transaction', { 
                amount: amount,
                code: 'A181024185637167', 
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getAccountD() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/get_account', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getAccountAgent() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/user_account', { 
                amount: amount, 
                account_no: "CUPD0000000120982",
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function take() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/self_transfer', {
                amount: '20.00',
                code: amount,
                trans_type: 1,
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function give() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/self_transfer', { 
                amount: '20.00',
                code: amount,
                trans_type: 2,
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function newAcct() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/create_account', { 
                amount: amount,

                firstname: "pat",
                lastname:  "ess",
                middlename: "na",
                dateOfBirth: "1990-05-10",
                identityType: "GHANACARD",
                identityNo: "GHA-724129349-7",
                idIssueDate: "2021-05-18",
                idExpiryDate: "2030-05-20",
                bvn: "233509596742",
                mobileNo: "233509596742",
                email: "pnessuman@ecobank.com",
                gender: "FEMALE",
                address: "Adenta",

            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function addAcct() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/add_account', {
                 amount: amount,

                 account_no: "CUPD0000000120982",
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getCode() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/get_code', { 
                amount: amount 
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }






        // 

        function deposit() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/deposit_gate', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function createAccount() {
            axios.post(apiUrl + '/create_account_gate', { phone: '0557522685' })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function withdraw() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/withdrawal_gate', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getAccount() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/get_account_gate', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getTransaction() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/get_transaction_gate', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getAccountBalance() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/get_account_balance_gate', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function selfTransfer() {
            const amount = document.getElementById('amount').value;
            axios.post(apiUrl + '/self_transfer_gate', { amount: amount })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>
</html>
