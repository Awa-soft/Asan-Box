<?php

use App\Models\Settings\Currency;

function getCurrencyDecimal($id=1){
    return Currency::find($id)->decimal;
}
function getCurrencySymbol($id=1){
    return Currency::find($id)->symbol;
}
function getCurrencyName($id=1){
    return Currency::find($id)->symbol;
}
function getCurrencyRate($id=1){
    return Currency::find($id)->rate;
}
function getRatePerOne($id = 1){
    return getCurrencyRate($id) / 100;
}

// currency converions
function convertToUsd($from_currency,$to_currency, $amount, $rate=null){
    if($from_currency == 1 && $to_currency ==1){
        return $amount;
    }
    if(!$rate){
        $rate = getRatePerOne($from_currency);
    }
    return $amount / $rate;
}
function convertToIqd($from_id, $amount, $rate=null){
    $usd = convertToUsd($from_id, $amount, $rate);
    $to_rate = getRatePerOne(2);
    return $usd * $to_rate;
}

function convertToCurrency($from_id, $to_id, $amount, $from_rate = null, $to_rate = null){
$usd = convertToUsd($from_id,$to_id, $amount, $from_rate);
if(!$to_rate){
    $to_rate = getRatePerOne($to_id);
}
if($from_id ==1 && $to_id == 2){
    return $amount * $to_rate;
}
if($to_id == 1){
    return $usd;
}
    return $usd * $to_rate;
}












