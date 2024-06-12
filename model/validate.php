<?php

/**
 * Class Validator
 * Provides static methods for input validation.
 */
class Validator
{
    /**
     * Validates an email address.
     *
     * @param string $email The email address to validate.
     * @return string|null Error message if validation fails, null if valid.
     */
    public static function validateEmail($email)
    {
        if (empty($email)) {
            return 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*\.com$/', $email)) {
            return 'Email must be a valid address and end with ".com"';
        }
        return null;
    }

    /**
     * Validates a username.
     *
     * @param string $username The username to validate.
     * @return string|null Error message if validation fails, null if valid.
     */
    public static function validateUsername($username)
    {
        if (empty($username)) {
            return 'Username is required';
        } elseif (strlen($username) < 5 || strlen($username) > 15) {
            return 'Username must be between 5 and 15 characters';
        }
        return null;
    }

    /**
     * Validates a comment.
     *
     * @param string $comment The comment to validate.
     * @return string|null Error message if validation fails, null if valid.
     */
    public static function validateComment($comment)
    {
        if (empty($comment)) {
            return 'Comment is required';
        } elseif (strlen($comment) < 1 || strlen($comment) > 500) {
            return 'Comment must be between 1 and 500 characters';
        }
        return null;
    }
}

?>
