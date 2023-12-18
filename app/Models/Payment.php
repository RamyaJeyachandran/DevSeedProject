<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'userId',
        'isSuccess',
        'code',
        'message',
        'merchantId',
        'merchantTransactionId',
        'transactionId',
        'amount',
        'state',
        'responseCode',
        'paymentType',
        'pgTransactionId',
        'pgServiceTransactionId',
        'bankTransactionId',
        'bankId',
        'utr',
        'cardType',
        'pgAuthorizationCode',
        'arn',
        'brn',
        'responseCodeDescription',
        'is_active',
        'created_by',
        'updated_by'
    ];
    public static function insertPayment($payment_data)
    {
        $user = new User;
        $session_userId = Session::get('userId');
        $userId=$user->getDecryptedId($session_userId);

        if($payment_data->data->paymentInstrument->type == 'UPI')
        {
            return static::create(
                [
                 'userId'=>$userId,
                 'isSuccess' => $payment_data->success,
                 'code'=>$payment_data->code,
                 'message' => $payment_data->message,
                 'merchantId'=>$payment_data->data->merchantId,
                 'merchantTransactionId'=>$payment_data->data->merchantTransactionId,
                 'transactionId'=>$payment_data->data->transactionId,
                 'amount'=>$payment_data->data->amount,
                 'state'=>$payment_data->data->state,
                 'responseCode'=>$payment_data->data->responseCode,
                 'paymentType'=>$payment_data->data->paymentInstrument->type,
                 'utr'=>$payment_data->data->paymentInstrument->utr,
                 'created_by'=>$userId
                ]
            );
        }else if($payment_data->data->paymentInstrument->type == 'CARD')
        {
            return static::create(
                [
                 'userId'=>$userId,
                 'isSuccess' => $payment_data->success,
                 'code'=>$payment_data->code,
                 'message' => $payment_data->message,
                 'merchantId'=>$payment_data->data->merchantId,
                 'merchantTransactionId'=>$payment_data->data->merchantTransactionId,
                 'transactionId'=>$payment_data->data->transactionId,
                 'amount'=>$payment_data->data->amount,
                 'state'=>$payment_data->data->state,
                 'responseCode'=>$payment_data->data->responseCode,
                 'paymentType'=>$payment_data->data->paymentInstrument->type,
                 'cardType'=>$payment_data->data->paymentInstrument->cardType,
                 'pgTransactionId'=>$payment_data->data->paymentInstrument->pgTransactionId,
                 'bankTransactionId'=>$payment_data->data->paymentInstrument->bankTransactionId,
                 'pgAuthorizationCode'=>$payment_data->data->paymentInstrument->pgAuthorizationCode,
                 'arn'=>$payment_data->data->paymentInstrument->arn,
                 'bankId'=>$payment_data->data->paymentInstrument->bankId,
                 'brn'=>$payment_data->data->paymentInstrument->brn,
                 'created_by'=>$userId
                ]
            );
        }
        else if($payment_data->data->paymentInstrument->type == 'NETBANKING')
        {
            return static::create(
                [
                 'userId'=>$userId,
                 'isSuccess' => $payment_data->success,
                 'code'=>$payment_data->code,
                 'message' => $payment_data->message,
                 'merchantId'=>$payment_data->data->merchantId,
                 'merchantTransactionId'=>$payment_data->data->merchantTransactionId,
                 'transactionId'=>$payment_data->data->transactionId,
                 'amount'=>$payment_data->data->amount,
                 'state'=>$payment_data->data->state,
                 'responseCode'=>$payment_data->data->responseCode,
                 'paymentType'=>$payment_data->data->paymentInstrument->type,
                 'pgTransactionId'=>$payment_data->data->paymentInstrument->pgTransactionId,
                 'pgServiceTransactionId'=>$payment_data->data->paymentInstrument->pgServiceTransactionId,
                 'bankTransactionId'=>$payment_data->data->paymentInstrument->bankTransactionId,
                 'bankId'=>$payment_data->data->paymentInstrument->bankId,
                 'created_by'=>$userId
                ]
            );
        }
    }
    public static function setSubcribed()
    {
        $user = new User;
        $session_userId = Session::get('userId');
        $userId=$user->getDecryptedId($session_userId);

        $userType = Session::get('userType');
        switch( $userType ) {
            case 2:
                $hospital_obj=new HospitalSettings;
                $hospital_obj->getSubscribed($userId);
                break;
            case 4:
                $branch_obj=new HospitalBranch;
                $branch_obj->getSubscribed($userId);
                break;
        }
    }
}
