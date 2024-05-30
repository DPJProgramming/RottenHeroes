<?php

class Validator
{
    public static function validateEmail($email)
    {
        if (empty($email)) {
            return 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*\.com$/', $email)) {
            return 'Email must be a valid address and end with ".com"';
        }
        return null;
    }

    public static function validateUsername($username)
    {
        if (empty($username)) {
            return 'Username is required';
        } elseif (strlen($username) < 5 || strlen($username) > 15) {
            return 'Username must be between 5 and 15 characters';
        }
        return null;
    }

    public static function validateComment($comment)
    {
        if (empty($comment)) {
            return 'Comment is required';
        } elseif (strlen($comment) < 5 || strlen($comment) > 500) {
            return 'Comment must be between 5 and 500 characters';
        }
        return null;
    }
}
?>
