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

defined('APP_PATH') or exit('No direct script access allowed');

if (!function_exists('rest_api')) {
    /**
     * Generate REST API
     * @param	string  $fileName   (File Name)
     * @param	string  $method     (Request method)
     * @param	string  $param      (Request parameter)
     * @param	string  $filePath	(File directory path)
     * @return	bool
     **/
    function rest_api($fileName, $method, $param, $filePath)
    {
        $path     = NULL;
        $function = NULL;

        $fileName = explode('/', $fileName);
        $class    = $fileName[array_key_last($fileName)];

        $fileName = explode('.', $class);
        $param    = explode(',', $param);

        $filePath = str_replace('\\', '/', $filePath);
        $filePath = explode('/', $filePath);
        $filePath = array_values($filePath);

        foreach ($filePath as $key => $value) {
            if (!file_exists(path() . $path . $value)) {
                mkdir(path() . $path . $value);
            }
            $path = $path . $value . DIRECTORY_SEPARATOR;
        }

        $helper   = '$this->helper("url");';
        $library  = '$this->library("api");';

        if ($method == 'POST') {
            $function = "\n\tpublic function index()\n\t{\n\t\techo 'Hello World!';\n\t}";
        }

        $code = "<?php\ndefined('APP_PATH') OR exit('No direct script access allowed');\nclass " . ucfirst($fileName[0]) . " extends Base_Controller\n{\n";
        $code .= "\tpublic function __construct()\n\t{\n\t\t$helper\n\t\t$library\n\t}\n\t$function";
        $code .= "\n}\n?>";

        if (!file_exists($path . ucfirst($fileName[0]) . '.php')) {
            $file = fopen($path . ucfirst($fileName[0]) . '.php', 'w');
            fwrite($file, $code);
        }

        return TRUE;
    }
}
