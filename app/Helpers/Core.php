<?php

use App\Models\Core\Package;
use App\Models\Settings\Currency;

function getCurrencyDecimal($id = 1)
{
    return Currency::find($id)?->decimal ?? 0;
}
function getBaseCurrency()
{
    return Currency::where('base', 1)->first();
}
function getBaseCurrencyRate()
{
    return Currency::where('base', 1)->first()->rate;
}
function getCurrencySymbol($id = 1)
{
    return Currency::find($id)?->symbol;
}
function getCurrencyName($id = 1)
{
    return Currency::find($id)?->symbol;
}
function getCurrencyRate($id = 1)
{
    return Currency::find($id)?->rate ?? 0;
}
function getRatePerOne($id = 1, $rate = null)
{
    if ($rate) {
        return $rate / 100;
    }
    return getCurrencyRate($id) / 100;
}

// currency converions
function convertToUsd($from_currency, $to_currency, $amount, $rate = null)
{
    if ($from_currency == 1 && $to_currency == 1) {
        return $amount;
    }
    if (!$rate) {
        $rate = getRatePerOne($from_currency);
    }
    return $amount / $rate;
}
function convertToIqd($from_id, $amount, $rate = null)
{
    $usd = convertToUsd($from_id, $amount, $rate);
    $to_rate = getRatePerOne(2);
    return $usd * $to_rate;
}

function convertToCurrency($from_id, $to_id, $amount, $from_rate = null, $to_rate = null)
{
    $usd = convertToUsd($from_id, $to_id, $amount, $from_rate);
    if (!$to_rate) {
        $to_rate = getRatePerOne($to_id);
    }
    if ($from_id == 1 && $to_id == 2) {
        return $amount * $to_rate;
    }
    if ($to_id == 1) {
        return $usd;
    }
    return $usd * $to_rate;
}


function packages(){
    return Package::all();
}

function getPackage($id){
    return Package::find($id);
}
function checkPackage($name){
    return Package::where('name', $name)->exists();
}

function valueInArray($value,$array):bool{
    if(in_array($value,$array) || $array == []){
        return true;
    }
    return false;
}

function getReceiptHeader(){
    return 'storage/'.(auth()->user()?->ownerable?->receipt_header != null ? auth()->user()?->ownerable?->receipt_header : \App\Models\Logistic\Branch::find(1)->receipt_header);
}

function getSidebar(){
    return auth()->user()->sidebar;;
}




