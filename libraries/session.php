<?php
    class session {
        public function __construct() {
            session_start();
        }
        
        public function set_session($name, $data) {
            $_SESSION[$name] = $data;
        }
        
        public function get_session($name) {
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            }else {
                return null;
            }
        }

        public function del_session($name) {
            unset($_SESSION[$name]);
        }
    }
?>
