<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\RequestLog;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\AccountUser;
use App\Models\Account;
use App\Models\User;

use Carbon\Carbon;

use App\Helper\Helpers;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Jobs\DynamicMailJob;

class BankingService {

    // later
}

