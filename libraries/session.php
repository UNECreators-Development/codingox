<?php
    class session {
        public function set_session($name, $data) {
            session_start();
            $_SESSION[$name] = $data;
        }
        
        public function get_session($name) {
            session_start();
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            }else {
                return null;
            }
        }

        public function del_session($name) {
            session_start();
            unset($_SESSION[$name]);
        }
    }
?>