<?php

require_once 'Security.php';

class Main {
    
    public static function run() {
        $json = self::Sale("sale123");
        $security = new Security();
        echo json_encode($json) . "\n";
        $enc = $security->encrypt(json_encode($json));
        echo $enc . "\n";
    }
    
    public static function Sale($trxId, $method = "") {
        $json = [
            "amount" => 1,
            "action" => "Sale",
            "trx_id" => $trxId,
            "pos_address" => "172.0.0.1",
            "time_stamp" => "2022-01-01 00:00:00"
        ];
        
        if (!empty($method)) {
            $json["method"] = $method;
        }
        
        return $json;
    }
    
    public static function SaleQris($trxId) {
        return self::Sale($trxId, "qris");
    }
    
    public static function SalePurchase($trxId) {
        return self::Sale($trxId, "purchase");
    }
    
    public static function SaleBrizzi($trxId) {
        return self::Sale($trxId, "brizzi");
    }
    
    public static function VoidQris($trxId) {
        return self::VoidTransaction($trxId, "qris");
    }
    
    public static function VoidPurchase($trxId) {
        return self::VoidTransaction($trxId, "purchase");
    }
    
    public static function VoidBrizzi($trxId) {
        return self::VoidTransaction($trxId, "brizzi");
    }
    
    public static function VoidTransaction($traceNum, $method) {
        return [
            "action" => "Void",
            "trace_number" => $traceNum,
            "pos_address" => "172.0.0.1",
            "time_stamp" => "2022-01-01 00:00:00",
            "method" => $method
        ];
    }
    
    public static function CheckStatusQris($refNum) {
        return [
            "action" => "Refund Qris",
            "reference_number" => $refNum,
            "pos_address" => "172.0.0.1",
            "time_stamp" => "2022-01-01 00:00:00",
            "method" => "qris"
        ];
    }
    
    public static function ReprintLastPurchase() {
        return self::ReprintLast("purchase");
    }
    
    public static function ReprintLastBrizzi() {
        return self::ReprintLast("brizzi");
    }
    
    public static function ReprintLast($method) {
        return [
            "action" => "Reprint Last",
            "pos_address" => "172.0.0.1",
            "time_stamp" => "2022-01-01 00:00:00",
            "method" => $method
        ];
    }
    
    public static function ReprintAnyPurchase($traceNum) {
        return self::ReprintAny($traceNum, "purchase");
    }
    
    public static function ReprintAnyBrizzi($traceNum) {
        return self::ReprintAny($traceNum, "brizzi");
    }
    
    public static function ReprintAny($traceNum, $method) {
        return [
            "action" => "Reprint Any",
            "pos_address" => "172.0.0.1",
            "time_stamp" => "2022-01-01 00:00:00",
            "trace_number" => $traceNum,
            "method" => $method
        ];
    }
    
    public static function SettlementPurchase() {
        return self::Settlement("purchase");
    }
    
    public static function SettlementBrizzi() {
        return self::Settlement("brizzi");
    }
    
    public static function Settlement($method) {
        return [
            "action" => "Settlement",
            "pos_address" => "172.0.0.1",
            "time_stamp" => "2022-01-01 00:00:00",
            "method" => $method
        ];
    }
}

Main::run();
