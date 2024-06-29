<?php

use Illuminate\Support\Facades\Route;



Route::get('/print/contracts',function(){
    $data = \Illuminate\Support\Facades\Session::get('contracts_data');
   return view('settings.contract')->with('data',$data);
})->name('print.contracts');
