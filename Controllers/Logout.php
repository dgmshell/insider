<?php
class Logout
{
    public function __construct()
    {
        session_start();
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: auth/login');
        exit();
    }
}