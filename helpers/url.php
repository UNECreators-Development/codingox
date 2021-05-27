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

/* URL Helper */

if (!function_exists('base_url')) {
	/** 
	 * Application Base URL
	 * @return	string http://url
	 **/
	function base_url()
	{
		return APP_URL . DIRECTORY_SEPARATOR . APP_PATH;
	}
}

if (!function_exists('site_url')) {
	/** 
	 * Alias of base_url()
	 * @param 	string $url 
	 * @return	string http://url
	 **/
	function site_url($url = '')
	{
		return APP_URL . DIRECTORY_SEPARATOR . APP_PATH . $url;
	}
}

if (!function_exists('media_url')) {
	/** 
	 * Application Media URL
	 * @param 	string $url 
	 * @return	string http://url
	 **/
	function media_url($url = '')
	{
		return APP_URL . DIRECTORY_SEPARATOR . APP_PATH . resources_path . DIRECTORY_SEPARATOR . $url;
	}
}

if (!function_exists('current_url')) {
	/** 
	 * Current URL 
	 * @return	string http://url
	 **/
	function current_url()
	{
		return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
}

if (!function_exists('redirect')) {
	/** 
	 * Redirect
	 * @param 	string $url 
	 * @param 	string $type Auto|Refresh 
	 * @return	redirection 
	 **/
	function redirect($url = null, $type = 'auto')
	{
		if ($url != null) {
			$type = $type == 'auto' ? 'Location:' : 'Refresh:0';
			header($type . APP_URL . DIRECTORY_SEPARATOR . APP_PATH . $url);
		} else {
			header('Refresh:0');
		}
	}
}

if (!function_exists('uri_parameter')) {
	/** 
	 * Get URL Data
	 * @param 	int $index
	 * @return	string|array
	 **/
	function uri_parameter(int ...$index)
	{
		$uriArray = array();
		$uri = array_filter(explode('/', $_SERVER['REQUEST_URI']));
		if (sizeof($index) > 1) {
			foreach ($index as $key => $value) {
				$uriArray[] = $uri[$value];
			}
			return $uriArray;
		} else {
			return $uri[$index[0]];
		}
	}
}
