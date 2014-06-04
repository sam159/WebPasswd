<?php

class PKCS5Padding {
  public static function Pad($unpaddedString, $blockSize) {
    $additionalChars = $blockSize - strlen($unpaddedString) % $blockSize;

    $char = chr($additionalChars);

    return $unpaddedString.str_repeat($char, $additionalChars);
  }
  public static function UnPad($paddedString) {
    $additionalChars = ord(substr($paddedString, -1, 1));

    return substr($paddedString, 0, -$additionalChars);
  }
}