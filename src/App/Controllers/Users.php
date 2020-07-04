<?php namespace Controllers;

use Models\Users as User;

/**
 * Class Stations
 *
 * @package Controllers
 */
class Users
{

    public function create($username, $password) {
        $user = new User();
        $user->username = $username;
        $user->password = $password;
        $user->save();

        return $user->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = User::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (User::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return User::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}