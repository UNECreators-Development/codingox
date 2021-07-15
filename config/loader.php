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
 * @link		https://codingox.epizy.com
 * @since		Version 1.2.0
 * @filesource
 **/

isset($config) or exit('No direct script access allowed');

/* Defined Constants */
require_once('config' . DIRECTORY_SEPARATOR . 'variables.php');

/* Handle All Error */
require_once(system_core . DIRECTORY_SEPARATOR . 'error_handler.php');

/* Load Base Controller */
require_once(system_core . DIRECTORY_SEPARATOR . 'Controller.php');

/* Match URI Pattern */
if ($config['URI_PATTERN'] != null) {
    $uri = str_replace('/', '', $_SERVER['REQUEST_URI']);
    if (!preg_match("/^[{$config['URI_PATTERN']}]*$/", $uri)) {
        trigger_error("Request can't process because this url contains disallowed characters.", E_USER_WARNING);
    }
}

/* Load Code Generator */
if ($page[0] == $config['ALLOW_URI']) {
    $validIP = false;
    foreach ($config['ALLOW_IP'] as $key => $value) {
        $remoteIP = ltrim($_SERVER['REMOTE_ADDR'], '[');
        $remoteIP = rtrim($remoteIP, ']');
        
        if ($remoteIP == trim($value)) {
            $validIP = true;
        }
    }

    if ($validIP == true) {
        require_once(system_code . DIRECTORY_SEPARATOR . 'Generator.php');
        exit();
    }
}

/* Load Controller */
$class = Base_Controller::$class = ucwords($page[0]);
$controller = Base_Controller::controller(controller_path);

if ($controller) {
    require_once($controller);

    $view = $page[1];
    $object = new $class;

    unset($page[0]);
    unset($page[1]);

    /* load view */
    if (substr($view, 0, 2) != '__') {
        if (method_exists($object, $view)) {
            $object->$view(...$page);
        } else {
            display_error();
        }
    } else {
        display_error();
    }
} else {
    display_error();
}
