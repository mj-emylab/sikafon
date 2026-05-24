
// // verifying if request is from our server before running any requesr check using the session_id in all my requests. this is a form of 2F2 auth
// url: https://sikafon.net:5001/verify_request
// type: post
// data: {
//     session_id: '547s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     expired_at: '',
//     created_at: '',
//     status: 1, // 1 => valid, 2 => invalid, 0 => error
//     session_id: '547s-3643-ch87' // my generated unique id for the request
// }





// // verifying card
// url: https://sikafon.net:5001/verify_chard
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     session_id: '547s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     expired_at: '',
//     issued_at: '',
//     status: 1, // 1 => valid, 2 => invalid, 0 => error
//     session_id: '547s-3643-ch87' // my generated unique id for the request
// }


// // create account
// url: https://sikafon.net:5001/register
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     phone: '',
//     email: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     account_no: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request
// }

// // get a user account
// url: https://sikafon.net:5001/account
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     phone: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     account_no: '',
//     balance: 325.00, //
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     last_transaction: 'timestamp'
// }


// // get a user accounts
// url: https://sikafon.net:5001/get_accounts
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     phone: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     account_no: '',
//     balance: 325.00, //
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     last_transaction: 'timestamp'
// }


// // get a user account status
// url: https://sikafon.net:5001/account
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     card_no: '',
//     account_no: '',
//     status_type: 1 // 1 => block, 2 => unblock, 0 => hold
//     phone: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     account_no: '',
//     balance: 325.00, //
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     last_transaction: 'timestamp'
// }

// // get a user transactions
// url: https://sikafon.net:5001/get_transactions
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     account_no: '',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     phone: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     filter: {
//         'page_id': 1, // for pagination
//         'key_word': '',
//         'date-from': '',
//         'date_to': '',
//         'max_rows': 100,
//         'status': 1, // 1, 2, 3, 0
//     }
// }
// response: {
//     account_no: '',
//     balance: 325.00, //
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     last_transaction: 'timestamp',
//     'transactions': [
//         {id: 1, status: '', type: 'in or out', created_at: '', session_id: ''},
//         {id: 1, status: '', type: 'in or out', created_at: '', session_id: ''}
//     ]
// }


// // get a transaction
// url: https://sikafon.net:5001/get_transaction
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     account_no: '',
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     phone: '',
//     session_id: '090s-3643-ch87' // my generated unique id for the request use this to find that transaction
// }
// response: {
//     account_no: '',
//     balance: 325.00, //
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     last_transaction: 'timestamp',
//     id: 1, 
//     status: '', 
//     type: 'in or out', 
//     created_at: '',
// }


// // create transaction
// url: https://sikafon.net:5001/create_transaction
// type: post
// data: {
//     first_name: 'Muhammed-Jamiu',
//     last_name: 'Yakubu',
//     account_no: ''
//     card_no: '',
//     card_type: 1 // 1 => ghana card, 2 => passport
//     phone: '',
//     amount: '',
//     transaction_type: 1, 
//     // 1 => take from the given account_no to our system account
//     // 2 => take from our account and put in the given account_no
//     // 0 => refund take from the given account_no to our system account

//     session_id: '090s-3643-ch87' // my generated unique id for the request
// }
// response: {
//     account_no: '',
//     balance: 325.00, //
//     session_id: '090s-3643-ch87' // my generated unique id for the request
//     last_transaction: 'timestamp',
//     id: 1, 
//     status: '', 
//     type: 'in or out', 
//     created_at: '',
// }






// // get all transactions
// url: https://sikafon.net:5001/transactions
// type: post
// data: {
//     session_id: '090s-3643-ch87' // my generated unique id for the request 
//     filter: {
//         'page_id': 1, // for pagination
//         'key_word': '',
//         'date-from': '',
//         'date_to': '',
//         'max_rows': 100,
//         'status': 1, // 1, 2, 3, 0
//     }
// }
// response: {
//     'transactions': [
//         {
//             account_no: '',
//             balance: 325.00, //
//             session_id: '090s-3643-ch87' // my generated unique id for the request
//             last_transaction: 'timestamp',
//             id: 1, 
//             status: '', 
//             type: 'in or out', 
//             created_at: '',
//         }
//     ],
//     session_id: '090s-3643-ch87'
// }


// // get all accounts
// url: https://sikafon.net:5001/accounts
// type: post
// data: {
//     session_id: '090s-3643-ch87' // my generated unique id for the request 
//     filter: {
//         'page_id': 1, // for pagination
//         'key_word': '',
//         'date-from': '',
//         'date_to': '',
//         'max_rows': 100,
//         'status': 1, // 1, 2, 3, 0
//     }
// }
// response: {
//     'accounts': [
//         {
//             account_no: '',
//             balance: 325.00, //
//             session_id: '090s-3643-ch87' // my generated unique id for the request
//             last_transaction: 'timestamp',
//             id: 1, 
//             status: '', 
//             created_at: '',
//         }
//     ],
//     session_id: '090s-3643-ch87'
// }