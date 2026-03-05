<?php 

use App\Helpers\Cart;
use App\Helpers\Gateway;

function cartHotelId(){
    if(Cart::hotel())
        return Cart::hotel()->id;
    else
        return 'null';
}

function cartQty(){
    return Cart::qty();
}

function cartSubtotal(){
    return Cart::subTotal();
}

function cartTax(){
    return Cart::tax();
}

function cartShipping(){
    return Cart::shipping();
}

function cartDiscount(){
    return Cart::discount();
}

function cartGrandTotal(){
    return Cart::grandTotal();
}

//////Hotels General functions
function getExtraPrice($extra){
    if($extra=='Sauce'){
        return '200';
    }
    if($extra=='Salmon'){
        return '100';
    }
    if($extra=='Salad'){
        return '150';
    } 
    if($extra=='Unagi'){
        return '200';
    }  
    if($extra=='Vegetables'){
        return '150';
    } 
    if($extra=='Noodles'){
        return '250';
    }
}
function gateway(){
    return new Gateway();
}

