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

isset($config) or exit('No direct script access allowed');

/* Application Configuration */
defined('config') or define('config', $config);

/* Application Path */
defined('APP_PATH') or define('APP_PATH', $AppPath);

/* Application URL */
defined('APP_URL') or define('APP_URL', $config['APP_URL']);

/* Controller Directory */
defined('controller_path') or define('controller_path', 'controllers');

/* View Directory */
defined('view_path') or define('view_path', 'views');

/* Model Directory */
defined('model_path') or define('model_path', 'models');

/* Helper Directory */
defined('helper_path') or define('helper_path', 'helpers');

/* Library Directory */
defined('library_path') or define('library_path', 'libraries');

/* System Directory */
defined('system_path') or define('system_path', 'system');

/* System Core Directory */
defined('system_core') or define('system_core', 'system/Core');

/* System Code Directory */
defined('system_code') or define('system_code', 'system/Code');

/* Web Resources Directory */
defined('resources_path') or define('resources_path', 'web');
