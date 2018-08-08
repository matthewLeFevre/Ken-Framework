<?php

  function base64URLEncode($data) {
    $urlSageData = strtr(base64_encode($data), '+/', '-_');
    return rtrim($urlSageData, '=');
  }
  function base64URLDecode(string $data){
    $urlUnsafeData = strtr($data, '-_', '+/');

    $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);

    return base64_decode($paddedData);
  }

  function generateJWT($userId) { // parameter for this function can include any size of payload
    $headerEncoded = base64URLEncode(json_encode(["alg" => "HS256", "typ" => "JWT"]));
    $payloadEncoded = base64URLEncode(json_encode(["userId" => $userId])); // may be changed determined on size of payload
    $dataEncoded = "$headerEncoded.$payloadEncoded";
    $rawSignature = hash_hmac('sha256', $dataEncoded, "thisIsMySecret", true);
    $signatureEncoded = base64URLEncode($rawSignature);
    $jwt = "$dataEncoded.$signatureEncoded";
    return $jwt;
  }

  function verifyToken($token) {
    
    list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);
 
    $dataEncoded = "$headerEncoded.$payloadEncoded";
 
    $signature = base64URLDecode($signatureEncoded);
 
    $rawSignature = hash_hmac('sha256', $dataEncoded, "thisIsMySecret", true); // you should use a much more secure secret
 
    return hash_equals($rawSignature, $signature);
  }
