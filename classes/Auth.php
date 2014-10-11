<?php

class Auth {

    private $sessionName = '';

    private $loggedin = false;
    private $bookFile;
    private $username;
    private $password;
    private $passwdBook;
    private $sessionKey = '';

    function __construct(array $config) {
        $this->sessionName = $config['Auth']['SessionName'];
        $this->username = $config['Auth']['Username'];
        $this->bookFile = $config['PasswdFile'];

        if (isset($_SESSION[$this->sessionName])) {
            $this->loggedin = $_SESSION[$this->sessionName]['loggedin'];
            $this->password = $_SESSION[$this->sessionName]['password'];
            $this->sessionKey = $_SESSION[$this->sessionName]['sessionKey'];
        }
        if ($this->isLoggedIn()) {
            if (strcmp($this->sessionKey, $_GET['skey']) !== 0 || empty($this->sessionKey)) {
                $this->logout();
            }
        }
    }

    function saveState() {
        $passwdBook = $this->getPasswdBook();

        if ($this->isLoggedIn()
            && $passwdBook instanceof PasswdBook
            && $passwdBook->hasChanged()
        ) {
            $crypt = new Crypt($this->bookFile, $this->password);
            $data = (string)$passwdBook;
            $result = $crypt->Encrypt($data);
            if ($result == false) {
                trigger_error("Crypt Failed. Could not save passwords file", E_USER_WARNING);
                return false;
            }
        }

        $_SESSION[$this->sessionName]['loggedin'] = $this->loggedin;
        $_SESSION[$this->sessionName]['password'] = $this->password;
        $_SESSION[$this->sessionName]['sessionKey'] = $this->sessionKey;
        return true;
    }

    function tryLogin($username, $password) {
        if ($this->loggedin == true) {
            return true;
        }
        if (!is_file($this->bookFile)) {
            return false;
        }

        $username = strtolower($username);
        if (strcmp($username, strtolower($this->username)) !== 0) {
            return false;
        }

        $crypt = new Crypt($this->bookFile, $password);

        $data = $crypt->Decrypt();
        if ($data == false) {
            return false;
        }

        $book = PasswdBook::CreateFromString($data);
        if (!$book instanceof PasswdBook) {
            return false;
        }

        $this->username = $username;
        $this->password = $password;
        $this->loggedin = true;
        $this->passwdBook = $book;
        $this->sessionKey = gen_random_string();

        $this->saveState();

        return true;
    }

    function logout() {
        unset($_SESSION[$this->sessionName]);
        $this->loggedin = false;
        $this->password = null;
        $this->sessionKey = '';
        $this->saveState();
    }

    function isLoggedIn() {
        return $this->loggedin;
    }

    function requireLoggedIn() {
        if (!$this->isLoggedIn()) {
            throw new NotAuthorisedException("Login Required");
        }
    }

    function updatePassword($current, $new) {

        if (!$this->isLoggedIn()) {
            throw new NotAuthorisedException("Login Required");
        }

        if (strcmp($current, $this->password) !== 0) {
            return false;
        }
        if (empty($new) || strlen($new) < 6) {
            return false;
        }

        $this->getPasswdBook()->markChanged();
        $this->password = $new;
        return $this->saveState();
    }

    /**
     * @return bool|PasswdBook
     */
    function getPasswdBook() {
        if ($this->loggedin !== true) {
            return false;
        }

        if ($this->passwdBook == false) {
            $crypt = new Crypt($this->bookFile, $this->password);

            $data = $crypt->Decrypt();
            if ($data == false) {
                return false;
            }

            $book = PasswdBook::CreateFromString($data);
            if (!$book instanceof PasswdBook) {
                return false;
            }
            $this->passwdBook = $book;
        }

        return $this->passwdBook;
    }

    function getSessionKey() {
        return $this->sessionKey;
    }

}