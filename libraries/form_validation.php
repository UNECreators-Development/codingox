<?php
    /* Form Validation Library */
    class form_validation {

        public function input_text($input) {
            if (!empty($_POST[$input])) {
                if (preg_match("/^[a-zA-Z-' ]*$/", $this->input($_POST[$input]))) {
                    return true;
                }else {
                    return "Invalid Data Format";
                }
            }else {
                return "Field is required";
            }
        }

        public function input_email($input) {
            if (!empty($_POST[$input])) {
                if (filter_var($this->input($_POST[$input]), FILTER_VALIDATE_EMAIL)) {
                    return true;
                }else {
                    return "Invalid email format";
                }
            }else {
                return "Field is required";
            }
        }

        public function input_url($input) {
            if (!empty($_POST[$input])) {
                if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->input($_POST[$input]))) {
                    return true;
                }else {
                    return "Invalid URL";
                }
            }else {
                return "Field is required";
            }
        }

        //Check and filter input data
        public function input($data) {
            if (is_array($data)) {
                $count = 0;
                foreach ($data as $key) {
                    if (!empty($_POST[$key])) {
                        $count++;
                    }
                }
                if (sizeof($data) == $count) {
                    return true;
                }
            }else if (!empty($_POST[$data])) {
                $data = trim($_POST[$data]);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        }

        //Request Type
        public function method() {
            return $_SERVER['REQUEST_METHOD'];
        }
    }
?>