<?php

/**
 * CodingOx
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author		Satyendra Sagar Singh
 * @license		https://opensource.org/licenses/MIT	MIT License
 * @link		http://framework.upgradeads.in
 * @since		Version 1.0.0
 * @filesource
 **/

defined('APP_PATH') or exit('No direct script access allowed');

/* session library */

class session
{
    /* Global variable */
    protected $flash;

    public function __construct()
    {
        /* Check session status */
        if ((bool) ini_get('session.auto_start')) {
            trigger_error('session.auto_start is enabled in php.ini', E_USER_WARNING);
        }

        $this->initialize();
        session_start();
    }

    /** 
     * initialize session
     * @return void
     **/
    public function initialize()
    {
        /* Set session save path */
        config['SESSION_PATH'] != NULL ? session_save_path(path() . config['SESSION_PATH']) : NULL;

        $session_life_time  = isset(config['SESSION_TIME']) && !empty(config['SESSION_TIME']) ? (int)config['SESSION_TIME'] : 0;

        $session_name       = isset(config['SESSION_NAME']) && !empty(config['SESSION_NAME']) ? config['SESSION_NAME'] : ini_get('session.name');

        $cookie_path        = isset(config['COOKIE_PATH']) ? config['COOKIE_PATH'] : '/';
        $cookie_domain      = isset(config['COOKIE_DOMAIN']) ? config['COOKIE_DOMAIN'] : NULL;
        $cookie_secure      = isset(config['COOKIE_SECURE']) ? (bool)config['COOKIE_SECURE'] : FALSE;
        $cookie_httponly    = isset(config['COOKIE_HTTPONLY']) ? (bool)config['COOKIE_HTTPONLY'] : FALSE;


        /* Set session cookie parameters */
        session_set_cookie_params(
            $session_life_time,
            $cookie_path,
            $cookie_domain,
            $cookie_secure,
            $cookie_httponly
        );

        /* Set session cookie property */
        ini_set('session.gc_maxlifetime', $session_life_time);
        ini_set('session.name', $session_name);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.use_cookies', 1);
    }

    /**
     * Set session value
     * @param	string $name	cookie name
     * @param	string $data 	cookie value
     * @return	bool
     **/
    public function set_value($name, $data)
    {
        $_SESSION[$name] = $data;
    }

    /**
     * Get session value
     * @param	string $name	cookie name
     * @return	string
     **/
    public function value($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    /**
     * Set flash data
     * @param	string $name	cookie name
     * @param	string $data 	cookie value
     * @return	bool
     **/
    public function set_flash($name, $data)
    {
        $_SESSION[$name] = $data;
    }

    /**
     * Get flash data
     * @param	string $name	cookie name
     * @return	string
     **/
    public function flash($name)
    {
        if ($this->flash != null) {
            return $this->flash;
        } else if (isset($_SESSION[$name])) {
            $this->flash = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $this->flash;
        } else {
            $this->flash = null;
            return $this->flash;
        }
    }

    /**
     * Clear session value
     * @param	string $name	cookie name
     * @return	bool
     **/
    public function unset_session($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Remove all session
     * @return	bool
     **/
    public function destroy_session()
    {
        session_destroy();
    }
}
