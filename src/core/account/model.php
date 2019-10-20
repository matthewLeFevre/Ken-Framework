<?php

class AccountModel {
  public static function seed($data) {
    $id = Dispatcher::dispatch(
      "INSERT INTO account 
      (account_name, account_created)
      VALUES
      (:account_name, :account_created)",
      $data,
      ['returnId' => TRUE]
    );

    $data['account_id'] = $id['id'];
    $data['email_code'] = '1234';
    Dispatcher::dispatch(
      "INSERT INTO email
      (email_address, email_code, account_id)
      VALUES
      (:email_address, :email_code, :account_id)",
      $data
    );
    Dispatcher::dispatch(
      "INSERT INTO pass
      (pass_hash, account_id)
      VALUES
      (:pass_hash, :account_id)",
      $data
    );
  }
  public static function get($data) {
    return Dispatcher::dispatch(
      "SELECT account.*, email.email_address, email.email_status FROM account
      INNER JOIN email
      ON account.account_id = email.account_id",
      $data,
      ['fetchConstant' => 'fetchAll']
    );
  }
  public static function getOne($data) {
    return Dispatcher::dispatch(
      "SELECT account.*, email.email_address, email.email_status FROM account
      INNER JOIN email
      ON account.account_id = email.account_id
      WHERE account.account_id = :account_id",
      $data,
      ['fetchConstant' => 'fetch']
    );
  }
}