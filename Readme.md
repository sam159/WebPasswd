WebPasswd
=========

Outline
-------

WebPasswd is a PHP web-app for storing personal login detail for websites.

No database is required, all data is stored in a single AES-256 encrypted file.

Requirements
------------

* PHP 5.3+, Webserver agnostic
* SSL is recommended and can be enforced through the config

Setup and Use
-------------

1. Upload all files to your webserver
2. Create your config.php (copy config.default.php)
   1. Set your path correctly if installing to a subdirectory.
   2. Change your username to what you prefer.
   3. Defined where your password file should go.

      This should be outside your public_html/htdocs directory so it cannot be accessed via the browser.
3. Open in a browser, you should be directed to install.php
4. Choose your password and click install (your password can be changed later)

   **Remember your password, it cannot be recovered if lost**
5. Delete install.php as it is no longer required
6. Done, You are good to go.

Currently no backup mechanism is provided, so you should make sure you have the password file backed up elsewhere.

Make use of the bookmarklet, it will allow you to quickly access/create the password entry for the current site.

Encryption
----------

The encryption is done via [mcrypt][2] using the Rijndael 256 algorithm (otherwise known as AES) using the CBC mode (Chain block cypher)

The encryption key is derived from your password and a once use IV using the [PBKDF2][1] algorithm.
A MAC via [HMAC][3]/SHA-256 is also used to verify the content on decryption.

[1]: https://en.wikipedia.org/wiki/PBKDF2
[2]: http://www.php.net//manual/en/book.mcrypt.php
[3]: https://en.wikipedia.org/wiki/Hash-based_message_authentication_code