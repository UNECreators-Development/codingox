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

/* File uploading library */

class media
{
	/* Global variables */
	protected $field 		= NULL;
	protected $uploadPath 	= NULL;
	protected $uploadError	= NULL;
	protected $fileName 	= NULL;
	protected $isUploaded 	= false;
	protected $_file 		= array();
	protected $config 		= array();

	/**
	 * File Upload
	 * @param	string	$name (input control name)
	 * @param	array	$config (fileType, fileSize, uploadPath etc.)
	 * @return	array|FALSE
	 **/
	public function upload(string $field, $config)
	{
		$this->field 	= $field;
		$this->config 	= $config;

		/* check path to upload file */
		if ($this->isValidPath()) {
			if ($this->isValidFile()) {
				$file_data = $this->isValidFile();
				/* Save file into dir */
				if (move_uploaded_file($file_data['file_tmp_name'], $file_data['file_full_path'])) {
					$this->isUploaded = true;
				}
				return $file_data;
			}
		}
		return FALSE;
	}

	/**
	 * Check Valid Path
	 * @return bool
	 **/
	protected function isValidPath()
	{
		if (isset($this->config['path'])) {
			$pathDir = array_filter(explode('/', $this->config['path']));
			$this->uploadPath  = path() . resources_path . DIRECTORY_SEPARATOR . implode('/', $pathDir) . DIRECTORY_SEPARATOR;

			if (realpath($this->uploadPath) !== FALSE) {
				$this->uploadPath = str_replace('\\', '/', realpath($this->uploadPath));
			}

			if (!is_dir($this->uploadPath)) {
				$this->uploadError = "Given filepath is not valid";
				return FALSE;
			}

			if (!is_writable($this->uploadPath)) {
				$this->uploadError = "Given filepath is not writable";
				return FALSE;
			}

			$this->uploadPath = preg_replace('/(.+?)\/*$/', '\\1/',  $this->uploadPath);
			return TRUE;
		} else {
			$this->uploadError = "No filepath defined";
			return FALSE;
		}
	}

	/**
	 * Check valid file
	 * @return array|FALSE
	 **/
	protected function isValidFile()
	{
		if (isset($_FILES[$this->field])) {
			$this->_file = $_FILES[$this->field];

			/* Check uploading errors */
			if (!is_uploaded_file($this->_file['tmp_name'])) {
				$error = isset($this->_file['error']) ? $this->_file['error'] : 4;

				switch ($error) {
					case UPLOAD_ERR_INI_SIZE:
						$this->uploadError = 'File exceeds limit';
						break;
					case UPLOAD_ERR_FORM_SIZE:
						$this->uploadError = 'File exceeds form limit';
						break;
					case UPLOAD_ERR_PARTIAL:
						$this->uploadError = 'File partial';
						break;
					case UPLOAD_ERR_NO_FILE:
						$this->uploadError = 'No file selected';
						break;
					case UPLOAD_ERR_NO_TMP_DIR:
						$this->uploadError = 'No temp directory';
						break;
					case UPLOAD_ERR_CANT_WRITE:
						$this->uploadError = 'Unable to write file';
						break;
					case UPLOAD_ERR_EXTENSION:
						$this->uploadError = 'Stopped by extension';
						break;
					default:
						$this->uploadError = 'No file selected';
						break;
				}

				return FALSE;
			}

			/* Check file size */
			if (isset($this->config['size'])) {
				if ($this->_file['size'] > ($this->config['size'] * 1024)) {
					$this->uploadError = "File is too large to upload";
					return FALSE;
				}
			}

			/* Check file type */
			if (isset($this->config['type'])) {
				/* Allowed extension to upload */
				$extension 	= str_replace(',', '|', $this->config['type']);
				$ext  		= explode('|', $extension);

				$file_ext 	= explode('.', $this->_file['name']);
				$file_ext 	= strtolower($file_ext[array_key_last($file_ext)]);

				if (!in_array($file_ext, $ext)) {
					$this->uploadError = "Only " . implode(', ', $ext) . " file allow to upload";
					return FALSE;
				}
			}

			return $this->file_data($this->_file);
		} else {
			$this->uploadError = "No file selected to upload";
		}
	}

	/**
	 * Return uploaded file data
	 * @param array $_file
	 * @return array|FALSE
	 **/
	protected function file_data()
	{
		$_file 			= $this->_file;
		$file_exts 		= explode('.', $_file['name']);
		$_file['exts'] 	= strtolower($file_exts[array_key_last($file_exts)]);
		$this->fileName	= (isset($this->config['name'])) ? $this->config['name'] . '.' . $_file['exts'] : basename($_file["name"]);

		$data = array(
			'file_name'		 => $this->fileName,
			'file_type'		 => $_file['type'],
			'file_size'		 => $_file['size'],
			'file_exts'		 => $_file['exts'],
			'file_path'		 => $this->uploadPath,
			'file_tmp_name'	 => $_file['tmp_name'],
			'file_full_path' => $this->uploadPath . $this->fileName,
			'file_mime_type' => @mime_content_type($_file['tmp_name']),
			'is_image_file'	 => $this->is_image(@mime_content_type($_file['tmp_name'])),
		);

		return $data;
	}

	/**
	 * Check wheather file is image or not
	 * @param string $mime file mime type
	 * @return bool
	 **/
	protected function is_image($mime)
	{
		$file_mime 	= null;
		$png_mimes  = array('image/x-png');
		$img_mimes 	= array('image/gif', 'image/jpeg', 'image/png');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

		if (in_array($mime, $png_mimes)) {
			$file_mime = 'image/png';
		} elseif (in_array($mime, $jpeg_mimes)) {
			$file_mime = 'image/jpeg';
		} elseif (in_array($mime, $img_mimes)) {
			$index = array_search($mime, $img_mimes);
			$file_mime = $img_mimes[$index];
		}

		return $file_mime != null ? TRUE : FALSE;
	}

	/**
	 * Set file name to upload
	 * @param 	string $fileName
	 * @return	bool
	 **/
	public function set_file_name(string $fileName)
	{
		if (preg_match("/^[a-zA-Z0-9_\-]*$/", $fileName)) {
			$this->config['name'] = trim($fileName);
			return TRUE;
		}
		$this->uploadError = 'File name contains disallowed character';
		return FALSE;
	}

	/**
	 * Get uploaded file name
	 * @return	string File Name
	 **/
	public function get_file_name()
	{
		return $this->fileName;
	}

	/**
	 * Check upload status
	 * @return	bool
	 **/
	public function is_uploaded()
	{
		return $this->isUploaded;
	}

	/**
	 * get upload error
	 * @return	string
	 **/
	public function upload_error()
	{
		return $this->uploadError;
	}
}
