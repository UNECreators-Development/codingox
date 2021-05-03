<?php
defined('APP_PATH') or exit('No direct script access allowed');
/* Form Validation Library */
class form
{
    protected $valid = 0;

    public function text($input)
    {
        if (!empty($_POST[$input])) {
            if (preg_match("/^[a-zA-Z-' ]*$/", $this->post($_POST[$input]))) {
                return true;
            } else {
                return "Invalid Data Format";
            }
        } else {
            return "Field is required";
        }
    }

    public function email($input)
    {
        if (!empty($_POST[$input])) {
            if (filter_var($this->post($_POST[$input]), FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return "Invalid email format";
            }
        } else {
            return "Field is required";
        }
    }

    public function link($input)
    {
        if (!empty($_POST[$input])) {
            if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->post($_POST[$input]))) {
                return true;
            } else {
                return "Invalid URL";
            }
        } else {
            return "Field is required";
        }
    }

    public function get($data)
    {
        $data = trim($_GET[$data]);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function post($data)
    {
        $data = trim($_POST[$data]);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function validate(...$arg)
    {
        $rules = ['required', 'min_length', 'max_length'];

        $rule = explode('|', $arg[2]);
        foreach ($rule as $key) :
            if (in_array($key, $rules)) :
                $this->{$key}($arg[0]);
            endif;
        endforeach;
    }

    protected function required($data)
    {
        !empty($_POST[$data]) ? $this->valid + 1 : $this->valid - 1;
    }
}
