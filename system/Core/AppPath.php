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

if (!function_exists('path')) {
	/**
	 * Dir Path
	 * @param	string|(optional) $dir directory name separated by comma
	 * @return	string Dir Path
	 **/
	function path(...$dir)
	{
		$base_path = "";
		$path = explode('\\', __DIR__);
		$root = explode('/', system_core);

		$path = array_values(array_filter(array_diff($path, $root, $dir)));

		foreach ($path as $key) {
			$base_path .= $key . DIRECTORY_SEPARATOR;
		}

		$base_path = APP_URL != "" ? "" : $base_path;

		return $base_path;
	}
}
