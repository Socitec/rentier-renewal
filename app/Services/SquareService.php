<?php


namespace App\Services;


use Square\SquareClient;

use Illuminate\Support\Str;

class SquareService
{
    public function __construct()
    {
        // スクエアアカウント設定
        $this->client = new SquareClient([
            'accessToken' => config('square.token'),
            'environment' => config('square.env'),
        ]);
    }

    public function createPayment($params, $money, $room_id, $name, $email, $keyword)
    {
    $amount_money = new \Square\Models\Money();
    $amount_money->setAmount($money);
    $amount_money->setCurrency('JPY');

    $key = $params['key-value'];
    $key_value = substr($key, 42, 32);

    $body = new \Square\Models\CreatePaymentRequest(
        $key_value,
        Str::uuid()->toString(),
        $amount_money
    );

    $api_response = $this->client->getPaymentsApi()->createPayment($body);

    if ($api_response->isSuccess()) {
        $result = $api_response->getResult();
        $result2 = $result->payment;
        $carddetail = $result2->cardDetails;
        $card = $carddetail->card;
        $cardbrand = $card->cardBrand;
        $last4 = $card->last4;
        $authresult = $carddetail->authResultCode;
        if ($keyword=='stay') {
            \DB::table('reservation_stay')
            ->where('room_id', $room_id)
            ->where('name', $name)
            ->where('email', $email)
            ->where('role', 1)
            ->update([
                'card_brand'=>$cardbrand,
                'last4'=>$last4,
                'accept_num'=>$authresult,
            ]);
        } elseif ($keyword=='time') {
            \DB::table('reservation_time')
            ->where('room_id', $room_id)
            ->where('name', $name)
            ->where('email', $email)
            ->where('role', 1)
            ->update([
                'card_brand'=>$cardbrand,
                'last4'=>$last4,
                'accept_num'=>$authresult,
            ]);
        }
    } else {
        $errors = $api_response->getErrors();
        var_dump($errors);
        throw new \Exception();
    }
}
}