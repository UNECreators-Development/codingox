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

/**
 * This file is allow to control your Web Apllication.
 * You can modify given variables according to your need.
 **/

/* Application live url */
$config['APP_URL'] = "";

/* Application default page */
$config['APP_PAGE'] = "index.php";

/* Application environment */
$config['APP_ENV'] = "development"; //production

/* Allow URL pattern to match request */
$config['URI_PATTERN'] = 'a-z A-Z 0-9%.:_\-';

/* Set session property */
$config['SESSION_TIME'] = 7200;
$config['SESSION_PATH'] = NULL;
$config['SESSION_NAME'] = 'session';

/* Set cookie property */
$config['COOKIE_PATH']		= '/';
$config['COOKIE_DOMAIN']	= '';
$config['COOKIE_SECURE']	= FALSE;
$config['COOKIE_HTTPONLY'] 	= FALSE;

/* Error logs property */
$config['LOG_FILE_PATH'] 		= NULL;
$config['LOG_FILE_NAME'] 		= 'error_log';
$config['LOG_FILE_EXTENSION'] 	= NULL;
$config['LOG_FILE_PERMISSION'] 	= 0644;

/* Allow IP and URL to access code generator */
$config['ALLOW_URI'] 	= 'code';
$config['ALLOW_IP'] 	= ['127.0.0.1', '::1']; //Remote device IP

/* Application base dir path */
$config['BASE_PATH'] = $_SERVER['DOCUMENT_ROOT'];
