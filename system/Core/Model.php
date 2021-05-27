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

/* Do Not Edit This File. This File Created For System Functionality. */

class_alias('Base_Model', 'My_Model');

class Base_Model
{
    /* global variable */
    public $path;
    protected $error;
    protected $param;

    /**
     * Class construct
     */
    public function __construct()
    {
        $this->path = path();
    }

    /**
     * @param 	string 					$method (function name)	
     * @param 	string|array|(optional) $arg	
     **/
    function __call($method, $arg)
    {
        $this->param = $arg;
        $errorMsg = " in <b>{$this->path}" . model_path . "/" . get_called_class() . ".php</b>";

        /* Load Helper */
        if ($method == 'helper') {
            $this->error = "Can not load helper ";
            $require = $this->load(helper_path);

            if ($require) {
                foreach ($require as $key => $value) {
                    require_once($value);
                }
            } else {
                trigger_error($this->error . $errorMsg, E_USER_NOTICE);
            }
        }

        /* Load Library */
        if ($method == 'library') {
            $this->error = "Can not load library ";
            $require = $this->load(library_path);

            if ($require) {
                foreach ($require as $key => $value) {
                    require_once($value);
                    $object = array_filter(explode('/', $this->param[$key]));
                    $this->{$object[array_key_last($object)]} = new $object[array_key_last($object)];
                }
            } else {
                trigger_error($this->error . $errorMsg, E_USER_NOTICE);
            }
        }

        /* Load Files */
        if ($method == 'load' || $method == 'require' || $method == 'include') {
            $this->error = "Can not load file ";
            $require = $this->load();

            if ($require) {
                foreach ($require as $key => $value) {
                    require_once($value);
                }
            } else {
                trigger_error($this->error . $errorMsg, E_USER_NOTICE);
            }
        }

        /* Load Database */
        if ($method == 'database') {
            $this->error = "Can not connect to database";
            if (file_exists($this->path . system_core . DIRECTORY_SEPARATOR . 'QueryBuilder.php')) {
                require_once($this->path . system_core . DIRECTORY_SEPARATOR . 'QueryBuilder.php');
                if (count($arg) == 0) :
                    $this->db = new QueryBuilder('');
                else :
                    $this->{$arg[0]} = new QueryBuilder($arg[0]);
                endif;
            } else {
                trigger_error($this->error . $errorMsg, E_USER_NOTICE);
            }
        }
    }

    /**
     * Set Parameter
     * @param   array $arg
     * @return  array
     **/
    protected function parameter($arg)
    {
        $param = array();
        if (is_array($arg[0])) {
            foreach ($arg[0] as $key => $value) {
                $param[] = $value;
            }
        } else {
            foreach ($arg as $key => $value) {
                $param[] = $value;
            }
        }

        return $param;
    }

    /**
     * Load files
     * @param   string|(optional) $dir
     * @return  array|FALSE
     **/
    protected function load($directory = null)
    {
        $require = array();
        $path = $this->path . $directory . DIRECTORY_SEPARATOR;

        foreach ($this->parameter($this->param) as $key => $value) {
            if (file_exists($path . $value . '.php')) {
                $require[] = $path . $value . '.php';
            } else {
                $this->error .= "<b>{$value}</b> ";
            }
        }

        if (count($this->parameter($this->param)) == count($require)) {
            return $require;
        }

        return FALSE;
    }
}
