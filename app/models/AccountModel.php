<?php
class AccountModel extends DB
{

    public function register($account)
    {
        $account['account_password'] = password_hash($account['account_password'], PASSWORD_DEFAULT);
        $sql = parent::$connection->prepare("INSERT INTO `accounts`( `account_username`, `account_password`, `account_telephone`, `account_email`) VALUES (?,?,?,?);");
        $sql->bind_param("ssss", $account['account_username'], $account['account_password'], $account['account_telephone'], $account['account_email']);
        return $sql->execute();
    }
    public function isAvailableAccount($account)
    {
        $sql = parent::$connection->prepare("SELECT COUNT(*) FROM `accounts` WHERE account_username  = ? ;");
        $sql->bind_param("s",  $account['account_username']);
        return parent::select_one($sql)['COUNT(*)'];
    }
    public function getTokenByIDAccount($id)
    {
        $sql = parent::$connection->prepare("SELECT  `token`,accounts.account_username as account_username FROM `account_token` INNER JOIN accounts ON accounts.id = account_token.account_id WHERE account_id = ?;");
        $sql->bind_param('i', $id);
        return parent::select_one($sql);
    }
    public function storeTokenForUser($account_id,$token)
    {
        $sql = parent::$connection->prepare("REPLACE INTO account_token SET account_id = ?, token = ?");
        $sql->bind_param('is', $account_id, $token);
        return $sql->execute();
    }
    public function getUserByUsername($username)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `accounts` WHERE account_username = ? LIMIT 1;");
        $sql->bind_param('i', $username);
        return parent::select_one($sql);
    }
    public function getUserByID($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `accounts` WHERE id = ? LIMIT 1;");
        $sql->bind_param('i', $id);
        return parent::select_one($sql);
    }
}
