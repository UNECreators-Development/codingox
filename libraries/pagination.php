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

/* Pagination library */

class pagination
{
    /* Global variable */
    protected $page         = 1;
    protected $limit        = NULL;
    protected $totalRows    = NULL;

    /**
     * Pagination
     * @param   object|string   $object
     * @param   int             $limit
     * @return  array           
     */
    public function paginate(object $object, int $limit)
    {
        $this->limit = $limit;
        if (isset($_GET['page'])) {
            $this->page = $_GET['page'];
        }

        $offset = ($this->page - 1) * $limit;
        $this->totalRows =  $object->db->table($object->table)->count();

        return $object->db->table($object->table)->limit($offset, $limit)->findAll();
    }

    /**
     * Create Links
     * @return  HTML Tags
     */
    public function links(string $url = NULL)
    {
        $totalPages = ceil($this->totalRows / $this->limit);

        if ($this->page == 1) {
            $prev = 1;
            if ($this->page >= $totalPages) {
                $next = $totalPages;
            } else {
                $next = $this->page + 1;
            }
        } else {
            $prev = ($this->page - 1);
            if ($this->page >= $totalPages) {
                $next = $totalPages;
            } else {
                $next = $this->page + 1;
            }
        }

        $html = '<ul class="pagination mt-3">';
        $html .= '<li class="page-item"><a class="page-link fa fa-angle-double-left" href="' . $url . '?page=' . $prev . '"></a></li>';
        for ($i = 1; $i <= $totalPages; $i++) {
            $class = NULL;
            if ($this->page == $i) {
                $class = "active";
            }
            $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
        }
        $html .= '<li class="page-item"><a class="page-link fa fa-angle-double-right" href="' . $url . '?page=' . $next . '"></a></li>';
        $html .= '</ul>';

        return $html;
    }
}
