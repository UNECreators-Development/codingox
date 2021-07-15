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
require_once('template.php');

if (!function_exists('controller')) {
	/**
	 * Generate Controller
	 * @param	string $class		(controller name)
	 * @param	string $action 		(view name)
	 * @param	string $viewPath	(view dir path)
	 * @return	bool
	 **/
	function controller($class, $action, $viewPath)
	{
		$function = NULL;

		$fileName = explode('/', $class);
		$class = $fileName[array_key_last($fileName)];
		unset($fileName[array_key_last($fileName)]);

		foreach ($fileName as $key => $value) {
			if (!file_exists(path() . controller_path . DIRECTORY_SEPARATOR . $value)) {
				mkdir(path() . controller_path . DIRECTORY_SEPARATOR . $value);
			}
		}

		$controller_path = path() . controller_path . DIRECTORY_SEPARATOR . implode('/', $fileName) . DIRECTORY_SEPARATOR;

		$fileName = explode('.', $class);
		$action = explode(',', $action);

		$viewPath = str_replace('\\', '/', $viewPath);
		$viewPath = explode('/', $viewPath);
		unset($viewPath[array_key_first($viewPath)]);

		$viewPath = array_values($viewPath);
		$viewPath = implode('/', $viewPath) . DIRECTORY_SEPARATOR;
		$helper = '$this->helper("html", "url");';

		for ($i = 0; $i < sizeof($action); $i++) {
			$view = '$this->view("' . $viewPath . trim($action[$i]) . '");';
			$function .= "\n\tpublic function " . trim($action[$i]) . "()\n\t{\n\t\t" . $view . "\n\t}\n\t";
		}

		$code = "<?php\ndefined('APP_PATH') OR exit('No direct script access allowed');\nclass " . ucfirst($fileName[0]) . " extends Base_Controller\n{\n";
		$code .= "\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t$helper\n\t}\n\t$function";
		$code .= "\n}\n?>";

		if (!file_exists($controller_path . ucfirst($fileName[0]) . '.php')) {
			$file = fopen($controller_path . ucfirst($fileName[0]) . '.php', 'w');
			fwrite($file, $code);
		}

		if (!file_exists(path() . view_path . DIRECTORY_SEPARATOR . $viewPath)) {
			mkdir(path() . view_path . DIRECTORY_SEPARATOR . $viewPath);
		}

		for ($i = 0; $i < sizeof($action); $i++) {
			if (!file_exists(path() . view_path . DIRECTORY_SEPARATOR . $viewPath . $action[$i] . '.php')) {
				$html = "<div class='container'>\n\t\t<div class='row p-2'>\n\t\t\t<div class='col-sm-12 card box'>\n\t\t\t\t<h4 style='align-self: center;'>This is auto generated view of <b>" . ucfirst($fileName[0]) . "/" . ucfirst($action[$i]) . "</b></h4>\n\t\t\t</div>\n\t\t</div>\n\t</div>";
				$file = fopen(path() . view_path . DIRECTORY_SEPARATOR . $viewPath . $action[$i] . '.php', 'w');
				fwrite($file, template($fileName[0] . ' | ' . ucwords($action[$i]), $html));
			}
		}

		return TRUE;
	}
}
