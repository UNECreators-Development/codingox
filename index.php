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
 
require('config' . DIRECTORY_SEPARATOR . 'config.php'); //Do Not Remove This Line.
require('config' . DIRECTORY_SEPARATOR . 'router.php'); //Do Not Remove This Line.

/* Application Environment */
if ($config['APP_ENV'] == "production") {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}

$AppPath = null; //Application Directory
$root = explode('/', $config['BASE_PATH']);
$path = explode('/',  str_replace('\\', '/', __DIR__));
$path = array_values(array_filter(array_diff($path, $root)));
$page = array_values(array_filter(explode('/', $_SERVER['PHP_SELF'])));
$page = array_values(array_filter(array_diff($page, $path, [$config['APP_PAGE']])));

foreach ($path as $key => $value) {
    $AppPath .= $value . '/';
}

/* Match Page Request */
foreach ($router as $key => $value) {
    if (isset($page[0])) {
        if ($page[0] == $key) {
            $pageArray = explode('/', $value);
            array_unshift($page, $pageArray[0]);
            $page[1] = $pageArray[1];
        }
    }
}

if (sizeof($page) == 0) {
    $page[0] = $router['default'];
    $page[1] = "index";
} else if (sizeof($page) == 1) {
    $page[1] = "index";
}

require_once('config' . DIRECTORY_SEPARATOR . 'loader.php');
exit();
