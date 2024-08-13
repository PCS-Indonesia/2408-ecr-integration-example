package org.example;

import org.json.simple.JSONObject;

public class Main {

    public static void main(String[] args) {
        JSONObject json = Sale("sale123");
        Security security = new Security();
        System.out.println(json.toJSONString());
        String enc = security.encrypt(json.toJSONString());
        System.out.println(enc);
    }

    public static JSONObject Sale(String trxId){
        return Sale(trxId, "");
    }
    public static JSONObject SaleQris(String trxId){
        return Sale(trxId, "qris");
    }
    public static JSONObject SalePurchase(String trxId){
        return Sale(trxId, "purchase");
    }
    public static JSONObject SaleBrizzi(String trxId){
        return Sale(trxId, "brizzi");
    }
    public static JSONObject Sale(String trxId, String method){
        JSONObject json = new JSONObject();
        json.put("amount", 1);
        json.put("action", "Sale");
        json.put("trx_id", trxId);
        json.put("pos_address", "172.0.0.1");
//        json.put("trace_number", "1");
        json.put("time_stamp", "2022-01-01 00:00:00");
        if(!method.isBlank()){
            json.put("method", method);
        }
        return json;
    }

    public static JSONObject VoidQris(String trxId){
        return Void(trxId, "qris");
    }
    public static JSONObject VoidPurchase(String trxId){
        return Void(trxId, "purchase");
    }
    public static JSONObject VoidBrizzi(String trxId){
        return Void(trxId, "brizzi");
    }
    public static JSONObject Void(String traceNum, String method){
        JSONObject json = new JSONObject();
        json.put("action", "Void");
        json.put("trace_number", traceNum);
        json.put("pos_address", "172.0.0.1");
        json.put("time_stamp", "2022-01-01 00:00:00");
        json.put("method", method);
        return json;
    }

    public static JSONObject CheckStatusQris(String refNum){
        JSONObject json = new JSONObject();
        json.put("action", "Refund Qris");
        json.put("reference_number", refNum);
        json.put("pos_address", "172.0.0.1");
        json.put("time_stamp", "2022-01-01 00:00:00");
        json.put("method", "qris");
        return json;
    }

    public static JSONObject ReprintLastPurchase(){
        return ReprintLast( "purchase");
    }
    public static JSONObject ReprintLastBrizzi(){
        return ReprintLast("brizzi");
    }

    public static JSONObject ReprintLast(String method){
        JSONObject json = new JSONObject();
        json.put("action", "Reprint Last");
        json.put("pos_address", "172.0.0.1");
        json.put("time_stamp", "2022-01-01 00:00:00");
        json.put("method", method);
        return json;
    }

    public static JSONObject ReprintAnyPurchase(int traceNum){
        return ReprintAny(traceNum, "purchase");
    }
    public static JSONObject ReprintAnyBrizzi(int traceNum){
        return ReprintAny(traceNum,"brizzi");
    }

    public static JSONObject ReprintAny(int traceNum, String method){
        JSONObject json = new JSONObject();
        json.put("action", "Reprint Any");
        json.put("pos_address", "172.0.0.1");
        json.put("time_stamp", "2022-01-01 00:00:00");
        json.put("trace_number", traceNum);
        json.put("method", method);
        return json;
    }

    public static JSONObject SettlementPurchase(){
        return Settlement("purchase");
    }
    public static JSONObject SettlementBrizzi(){
        return Settlement("brizzi");
    }

    public static JSONObject Settlement(String method){
        JSONObject json = new JSONObject();
        json.put("action", "Settlement");
        json.put("pos_address", "172.0.0.1");
        json.put("time_stamp", "2022-01-01 00:00:00");
        json.put("method", method);
        return json;
    }
}