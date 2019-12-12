<?php

namespace KenFramework\Utilities;

class JWT
{
  public static function base64Encode($data)
  {
    $urlSafeData = strtr(base64_encode($data), '+/', '-_');
    return rtrim($urlSafeData, '=');
  }

  public static function base64Decode($data)
  {
    $urlUnsafeData = strtr($data, '-_', '+/');
    $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
    return base64_decode($paddedData);
  }

  // testing this method instead of the other one.
  public static function base64EncodeTest($data)
  {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
  }

  public static function generateJWT($tokenClaims)
  {
    $headerEncoded = self::base64URLEncodeTest(json_encode(["alg" => "HS256", "typ" => "JWT"]));
    $payloadEncoded = self::base64URLEncodeTest(json_encode($tokenClaims)); // may be changed determined on size of payload
    $dataEncoded = "$headerEncoded.$payloadEncoded";
    $rawSignature = hash_hmac('sha256', $dataEncoded, "thisIsMySecret", true);
    $signatureEncoded = self::base64URLEncodeTest($rawSignature);
    $jwt = "$dataEncoded.$signatureEncoded";
    return $jwt;
  }

  public static function verifyToken($token)
  {
    list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);
    $dataEncoded = "$headerEncoded.$payloadEncoded";
    $signature = self::base64URLDecode($signatureEncoded);
    $rawSignature = hash_hmac('sha256', $dataEncoded, "thisIsMySecret", true); // you should use a much more secure secret
    return hash_equals($rawSignature, $signature);
  }
}
