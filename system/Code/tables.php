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

/* Set Database Connection */
require(path() . 'config' . DIRECTORY_SEPARATOR . 'database.php');

$opt = NULL;
$db  = $database['default'];

if ($db['database'] != NULL) {
    $connectionObject = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);

    if ($connectionObject) {
        $object = $connectionObject->query('SHOW TABLES');

        while ($table = mysqli_fetch_array($object)) {
            $opt .= "<option>{$table[0]}</option>";
        }
    } else {
        mysqli_connect_error();
    }
}
