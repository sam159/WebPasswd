<?php

require_once BASE_DIR.DS.'PasswordHash.php';

final class Crypt {
  const VERSION = 'fb469bab2938403095a70ee81f6d393f';
  const CYPHER = MCRYPT_RIJNDAEL_256; //aka AES-256
  const CYPHER_MODE = MCRYPT_MODE_CBC;
  const KEY_HASH = 'sha256';
  const KEY_HASH_ROUNDS = 1000;

  private $password;
  private $file;

  public function __construct($file, $password) {
    $this->file = $file;
    $this->password = $password;
  }

  public function Decrypt() {
    //Check that we can read the file
    if (!is_readable($this->file)) {
      return false;
    }

    //Open and lock for reading
    $fh = fopen($this->file, 'rb');
    if ($fh == false) {
      return false;
    }
    flock($fh, LOCK_SH);

    //Read the version string from the file and compare to our version
    list(,$version) = unpack('a'.strlen(self::VERSION), fread($fh, strlen(self::VERSION)));
    if (strcmp($version, self::VERSION) !== 0) {
      flock($fh, LOCK_UN); fclose($fh);
      return false;
    }

    //Read the length of the iv
    list(,$ivLength) = unpack('S', fread($fh, 2));
    if ($ivLength < 1) {
      flock($fh, LOCK_UN); fclose($fh);
      return false;
    }

    //Read the iv
    list(,$iv) = unpack('a'.$ivLength, fread($fh, $ivLength));
    if(strlen($iv) < $ivLength) {
      flock($fh, LOCK_UN); fclose($fh);
      return false;
    }

    //Read the MAC, the length is determined also
    $macLength = strlen(hash_hmac(self::KEY_HASH, 'test', 'test', true));
    $mac = fread($fh, $macLength);

    //Initialise mcrypt
    $td = mcrypt_module_open(self::CYPHER, '', self::CYPHER_MODE, '');

    //We already have our IV, generate the key
    $key = pbkdf2(self::KEY_HASH, $this->password, $iv, self::KEY_HASH_ROUNDS, mcrypt_enc_get_key_size($td), true);

    //Setup mcrypt with the key and IV
    if (mcrypt_generic_init($td, $key, $iv) < 0) {
      mcrypt_module_close($td);
      flock($fh, LOCK_UN); fclose($fh);
      return false;
    }

    //Read the remainder of the file and decrypt
    $data = "";
    while(!feof($fh)) {
      $data .= fread($fh, 1024);
    }

    $decryptedData =  mdecrypt_generic($td, $data);

    //Done decrypting. Close mcrypt and the file
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    flock($fh, LOCK_UN);
    fclose($fh);

    //Remove the padding
    $decryptedData = PKCS5Padding::UnPad($decryptedData);

    //Verify MAC
    if ($mac !== hash_hmac(self::KEY_HASH, $decryptedData, $this->password, true)) {
      return false;
    }

    return $decryptedData;
  }

  public function Encrypt($data) {
    //Initialize mcrypt
    $td = mcrypt_module_open(self::CYPHER, '', self::CYPHER_MODE, '');

    //Generate our IV and key
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
    $key = pbkdf2(self::KEY_HASH, $this->password, $iv, self::KEY_HASH_ROUNDS, mcrypt_enc_get_key_size($td), true);

    //Generate the MAC for the given data
    $mac = hash_hmac(self::KEY_HASH, $data, $this->password, true);

    //Setup mcrypt for the key and iv
    if (($r = mcrypt_generic_init($td, $key, $iv)) < 0) {
      mcrypt_module_close($td);
      return false;
    }

    //Pad the data
    $data = PKCS5Padding::Pad($data, mcrypt_enc_get_block_size($td));

    $encryptedData = mcrypt_generic($td, $data);

    //Encryption done. Close mcrypt
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    //Open and lock the file for writing
    $fh = fopen($this->file, 'cb');
    if ($fh == false) {
      return false;
    }
    flock($fh, LOCK_EX);
    //Only truncate after lock
    ftruncate($fh, 0);

    //Format <version><iv length><iv><mac><encrypted data>
    fwrite($fh, pack('a'.strlen(self::VERSION).'Sa'.strlen($iv), self::VERSION, strlen($iv), $iv));
    fwrite($fh, $mac);
    fwrite($fh, $encryptedData);
    flock($fh, LOCK_UN);
    fclose($fh);

    return true;
  }
}