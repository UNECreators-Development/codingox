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

if (!function_exists('form')) {
	/**
	 * Generate Form
	 * @param	string $fileName	(view name)
	 * @param	string $fields 		(field name)
	 * @param	string $viewPath	(view dir path)
	 * @return	bool
	 **/
	function form($fileName, $fields, $viewPath)
	{
		$input = "";
		$fileName = explode('.', $fileName);
		$fields = explode(',', $fields);
		$viewPath = str_replace('\\', '/', $viewPath);
		$viewPath = explode('/', $viewPath);
		unset($viewPath[0]);
		$viewPath = array_values($viewPath);
		$viewPath = implode('/', $viewPath) . DIRECTORY_SEPARATOR;

		for ($i = 0; $i < sizeof($fields); $i++) {
			$type 	= 'text';
			$label 	= trim($fields[$i]);
			$string = str_replace('(', '|', $fields[$i]);
			$string = str_replace(')', '|', $string);
			$string = array_filter(explode('|', $string));

			if (count($string) > 1) {
				$type 	= trim($string[1]);
				$label 	= trim($string[0]);
			}

			$field = "<label for='" . $label . "'>" . ucfirst($label) . "</label>\n\t\t\t\t<input type='{$type}' name='" . $label . "' id='" . $label . "' class='form-control' placeholder='Enter " . $label . "' required />";
			$input .= "\t\t\t<div class='form-group'>\n\t\t\t\t$field\n\t\t\t</div>\n";
		}

		$input .= "\t\t\t<div class='form-group'>\n\t\t\t\t<button type='submit' class='btn btn-success'>Submit</button>\n\t\t\t</div>\n";

		$content = "<div class='container'>\n\t\t<form action='' method='post'>\n$input\t\t</form>\n\t</div>";
		$form = template($fileName[0], $content);

		if (!file_exists(path() . view_path . DIRECTORY_SEPARATOR . $viewPath)) {
			mkdir(path() . view_path . DIRECTORY_SEPARATOR . $viewPath);
		}

		if (!file_exists(path() . view_path . DIRECTORY_SEPARATOR . $viewPath . $fileName[0] . '.php')) {
			$file = fopen(path() . view_path . DIRECTORY_SEPARATOR . $viewPath . $fileName[0] . '.php', 'w');
			fwrite($file, $form);
		}

		return true;
	}
}
