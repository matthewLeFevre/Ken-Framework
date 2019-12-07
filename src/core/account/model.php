<?php

class AccountModel
{
  public static function seed($data)
  {
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
  public static function get($data)
  {
    return Dispatcher::dispatch(
      "SELECT * FROM account",
      $data,
      ['fetchConstant' => 'fetchAll']
    );
  }
  public static function getOne($data)
  {
    return Dispatcher::dispatch(
      "SELECT * FROM account
      WHERE id = :id",
      $data,
      ['fetchConstant' => 'fetch']
    );
  }
  public static function create($data)
  {
    return Dispatcher::dispatch(
      "INSERT INTO account 
      (email, passHash, `name`)
      VALUES
      (:email, :passHash, :name)",
      $data
    );
  }
  public static function getByEmail($data)
  {
    return Dispatcher::dispatch(
      "SELECT * FROM account WHERE email = :email",
      $data,
      ['fetchConstant' => 'fetch']
    );
  }
  public static function getAuthData($data)
  {
    return Dispatcher::dispatch(
      "SELECT id, email, `name`, created, verification 
      FROM account 
      WHERE id = :id",
      $data,
      ['fetchConstant' => 'fetch']
    );
  }
}
