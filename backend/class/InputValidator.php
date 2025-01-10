<?php
class InputValidator {
    public static function sanitizeString($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateInt($input, $min = null, $max = null) {
        $options = [];
        if ($min !== null) {
            $options['options']['min_range'] = $min;
        }
        if ($max !== null) {
            $options['options']['max_range'] = $max;
        }
        return filter_var($input, FILTER_VALIDATE_INT, $options);
    }
}