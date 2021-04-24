<?php
    defined('APP_PATH') OR exit('No direct script access allowed');
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

        public function unset_session($name) {
            session_start();
            unset($_SESSION[$name]);
        }

        public function destroy_session() {
            session_start();
            session_destroy();
        }

        public function set_flash($name, $data) {
            session_start();
            $_SESSION[$name] = $data;
        }

        public function get_flash($name) {
            $flash = "";
            session_start();
            if (isset($_SESSION[$name])) {
                $flash = $_SESSION[$name];
            }else {
                $flash = null;
            }
            unset($_SESSION[$name]);
            return $flash;
        }
    }
?>