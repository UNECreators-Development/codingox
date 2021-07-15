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

require_once('Controller.php');
require_once('rest_api.php');
require_once('tables.php');
require_once('Model.php');
require_once('Form.php');

$status = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") :
    if (isset($_POST['controllerClass'])) :
        $fileName = explode('/', $_POST['controllerClass']);
        $class = $fileName[array_key_last($fileName)];
        unset($fileName[array_key_last($fileName)]);

        $controller_path = path() . controller_path . DIRECTORY_SEPARATOR . implode('/', $fileName) . DIRECTORY_SEPARATOR;
        $fileName = explode('.', $class);

        if (!file_exists($controller_path . ucfirst($fileName[0]) . '.php')) :
            echo "success";
        else :
            echo "already";
        endif;

        exit();
    endif;

    if (isset($_POST['type'])) :
        if ($_POST['type'] == "controller") :
            if (!empty($_POST['controller']) && !empty($_POST['action']) && !empty($_POST['viewPath'])) :
                $status = controller($_POST['controller'], $_POST['action'], $_POST['viewPath']);
            endif;
        elseif ($_POST['type'] == "model") :
            if (!empty($_POST['model']) && !empty($_POST['modelPath'])) :
                $status = model($_POST['model'], $_POST['operation'], $_POST['modelPath']);
            endif;
        elseif ($_POST['type'] == "form") :
            if (!empty($_POST['viewName']) && !empty($_POST['field']) && !empty($_POST['viewPath'])) :
                $status = form($_POST['viewName'], $_POST['field'], $_POST['viewPath']);
            endif;
        elseif ($_POST['type'] == "api") :
            if (!empty($_POST['fileName']) && !empty($_POST['method']) && !empty($_POST['param']) && !empty($_POST['filePath'])) :
                $status = rest_api($_POST['fileName'], $_POST['method'], $_POST['param'], $_POST['filePath']);
            endif;
        endif;
    endif;
endif;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="none">
    <title>Welcome To CodeGenerator</title>
    <link href="<?= APP_URL . DIRECTORY_SEPARATOR . APP_PATH; ?>web/system/image/logo.png" rel="icon">
    <link href="<?= APP_URL . DIRECTORY_SEPARATOR . APP_PATH; ?>web/system/css/main.css" rel="stylesheet">
    <script src="<?= APP_URL . DIRECTORY_SEPARATOR . APP_PATH; ?>web/system/js/jquery.js"></script>
    <script src="<?= APP_URL . DIRECTORY_SEPARATOR . APP_PATH; ?>web/system/js/bootstrap.js"></script>
</head>

<body>
    <div class="page-container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="javascript:void(0)"><b>CodingOx</b></a>

                <div class="collapse navbar-collapse" id="gii-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="javascript:void(0)">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL . DIRECTORY_SEPARATOR . APP_PATH; ?>">Application</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container content-container">
            <div class="default-index">
                <h1 class="border-bottom pb-3 mb-3">Welcome to Code Generator</h1>

                <div class="row mt-5">
                    <div class="generator col-lg-4">
                        <h3>Controller Generator</h3>
                        <p>This generator generate a new controller class with one or several controller actions and
                            views.</p>
                        <p><a class="btn btn-outline-secondary" href="#controller">Start »</a></p>
                    </div>
                    <div class="generator col-lg-4">
                        <h3>Model Generator</h3>
                        <p>This generator generates a Model class for the specified database and all database queries.
                        </p>
                        <p><a class="btn btn-outline-secondary" href="#model">Start »</a></p>
                    </div>
                    <div class="generator col-lg-4">
                        <h3>Form Generator</h3>
                        <p>This generator generates a view file that displays a form to collect input for the
                            specified Controller class.</p>
                        <p><a class="btn btn-outline-secondary" href="#form">Start »</a></p>
                    </div>
                    <div class="generator col-lg-4">
                        <h3>API Generator</h3>
                        <p>This generator generates a PHP script file that contains REST API to perform actions and return JSON data.</p>
                        <p><a class="btn btn-outline-secondary" href="#api">Start »</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8" id="controller" style="display: none">
                <div class="default-view">
                    <h1>Controller Generator</h1>
                    <form id="controller-generator" action="" method="post">
                        <div class="row">
                            <div class="col-lg-8 col-md-10" id="form-fields">
                                <div class="form-group field-generator-controllerclass required">
                                    <input type="hidden" name="type" value="controller">
                                    <label class="control-label help" title="This is the name of the controller class to be generated." for="generator-controllerclass">Controller Class</label>
                                    <input type="text" id="generator-controllerclass" class="form-control" name="controller" aria-required="true" required placeholder="ex: admin" />
                                    <p id="controllerMsg" class="mt-2 text-danger" style="display: none"></p>
                                </div>
                                <div class="form-group field-generator-actions">
                                    <label class="control-label help" title="Provide one or multiple action IDs to generate empty action method(s) in the controller. Separate multiple action IDs with commas or spaces. Action IDs should be in lower case." for="generator-actions">Action IDs</label>
                                    <input type="text" id="generator-actions" class="form-control" name="action" value="index,about" required>
                                </div>
                                <div class="form-group field-generator-viewpath">
                                    <label class="control-label help" data-toggle="popover" title="Specify the directory for storing the view scripts for the controller." data-placement="right" for="generator-viewpath">View Path</label>
                                    <input type="text" id="generator-viewpath" value="<?= view_path; ?>/" class="form-control" name="viewPath" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="btn-controller" disabled class="btn btn-primary" name="preview">Generate</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-md-9 col-sm-8" id="model" style="display: none">
                <div class="default-view">
                    <h1>Model Generator</h1>
                    <form id="model-generator" action="" method="post">
                        <div class="row">
                            <div class="col-lg-8 col-md-10" id="form-fields">
                                <div class="form-group field-generator-modelclass required">
                                    <input type="hidden" name="type" value="model">
                                    <label class="control-label help" title="This is the name of the table to generate model." for="generator-modelclass">Table Name</label>
                                    <select id="generator-modelclass" class="form-control" name="model" aria-required="true" required>
                                        <option value="">--Select Table--</option>
                                        <?= $opt; ?>
                                    </select>
                                </div>
                                <div class="form-group field-generator-actions">
                                    <label class="control-label" for="generator-actions">Operations</label><br />
                                    <input type="checkbox" name="operation[]" value="select" checked> Select &nbsp;
                                    <input type="checkbox" name="operation[]" value="insert" checked> Insert &nbsp;
                                    <input type="checkbox" name="operation[]" value="update" checked> Update &nbsp;
                                    <input type="checkbox" name="operation[]" value="delete" checked> Delete &nbsp;
                                    <input type="checkbox" name="operation[]" value="insert_or_update" checked> Insert OR Update &nbsp;
                                </div>
                                <div class="form-group field-generator-viewpath">
                                    <label class="control-label help" data-toggle="popover" title="Specify the directory for storing the model scripts." data-placement="right" for="generator-modelpath">Model Path</label>
                                    <input type="text" id="generator-modelpath" value="<?= model_path; ?>/" class="form-control" name="modelPath" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="btn-model" class="btn btn-primary" name="preview">Generate</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-md-9 col-sm-8" id="form" style="display: none">
                <div class="default-view">
                    <h1>Form Generator</h1>
                    <form id="form-generator" action="" method="post">
                        <div class="row">
                            <div class="col-lg-8 col-md-10" id="form-fields">
                                <div class="form-group field-generator-viewname required">
                                    <input type="hidden" name="type" value="form">
                                    <label class="control-label help" title="This is the view name with respect to the view path." for="generator-viewname">View Name</label>
                                    <input type="text" id="generator-viewname" class="form-control" name="viewName" aria-required="true" aria-invalid="true" required placeholder="ex: contact" />
                                </div>
                                <div class="form-group field-generator-field required">
                                    <label class="control-label help" title="This is the form field for collecting the form input." for="generator-field">Form Field</label>
                                    <input type="text" id="generator-field" value="name,number" class="form-control" name="field" aria-required="true" required>
                                </div>
                                <div class="form-group sticky field-generator-viewpath required">
                                    <label class="control-label help" title="This is the root view path to keep the generated view files. You may provide either a directory or a path." for="generator-viewpath">View Path</label>
                                    <input type="text" id="generator-viewpath" class="form-control" name="viewPath" value="<?= view_path; ?>/" aria-required="true" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="preview">Generate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-9 col-sm-8" id="api" style="display: none">
                <div class="default-view">
                    <h1>API Generator</h1>
                    <form id="api-generator" action="" method="post">
                        <div class="row">
                            <div class="col-lg-8 col-md-10" id="form-fields">
                                <div class="form-group field-generator-api required">
                                    <input type="hidden" name="type" value="api">
                                    <label class="control-label help" title="This is the file name with respect to the controller path." for="generator-filename">File Name</label>
                                    <input type="text" id="generator-filename" class="form-control" name="fileName" aria-required="true" aria-invalid="true" required placeholder="ex: Login" />
                                </div>
                                <div class="form-group field-generator-method required">
                                    <label class="control-label help" title="This is the method to handle server request." for="generator-method">Request Method</label>
                                    <select name="method" id="generator-method" class="form-control" aria-required="true" required>
                                        <option value=''>--Select Method--</option>
                                        <option value="GET">GET</option>
                                        <option value="PUT">PUT</option>
                                        <option value="POST">POST</option>
                                        <option value="PATCH">PATCH</option>
                                    </select>
                                </div>
                                <div class="form-group field-generator-param required">
                                    <label class="control-label help" title="This is the parameter field for collecting data." for="generator-param">Parameter</label>
                                    <input type="text" id="generator-param" value="number,password" class="form-control" name="param" aria-required="true" required>
                                </div>
                                <div class="form-group sticky field-generator-filepath required">
                                    <label class="control-label help" title="This is the root file path to keep the generated files. You may provide either a directory or a path." for="generator-filepath">File Path</label>
                                    <input type="text" id="generator-filepath" class="form-control" name="filePath" value="<?= controller_path; ?>/" aria-required="true" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="preview">Generate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-fix"></div>
        </div>
    </div>
    <footer class="footer border-top">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <p>&copy; 2021. All Rights Reserved.</p>
                </div>
                <div class="col-6">
                    <p class="text-right">Powered by <a href="https://codingox.epizy.com" rel="external">CodingOx</a></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Status Modal -->
    <div class="modal fade" id="status" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-center">File Successfully Generated...</h3>
                </div>
                <div class="text-center p-3">
                    <button type="button" id="btn-status" class="btn btn-success">Continue...</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        // Open Forms
        $('a[href^="#"]').click(function() {
            var target = $(this).attr('href');
            if (target == "#controller") {
                $('#model').hide();
                $('#form').hide();
                $('#api').hide();
                $(target).show();
            } else if (target == "#model") {
                $('#controller').hide();
                $('#form').hide();
                $('#api').hide();
                $(target).show();
            } else if (target == "#form") {
                $('#controller').hide();
                $('#model').hide();
                $('#api').hide();
                $(target).show();
            } else if (target == "#api") {
                $('#controller').hide();
                $('#model').hide();
                $('#form').hide();
                $(target).show();
            } else {
                $('#controller').hide();
                $('#model').hide();
                $('#form').hide();
                $('#api').hide();
            }
        });
        // Check Exists Files
        $('#generator-controllerclass').keyup(function() {
            $.ajax({
                url: "",
                type: "POST",
                data: {
                    controllerClass: $(this).val()
                },
                success: function(response) {
                    if (response == "success") {
                        $('#controllerMsg').hide();
                        $('#btn-controller').prop('disabled', false);
                    } else {
                        $('#controllerMsg').show();
                        $('#btn-controller').prop('disabled', true);
                        $('#controllerMsg').html('Class Already Exists.');
                    }
                },
                error: function() {
                    console.log('Error');
                }
            })
        })
        // Hide Status Modal
        $('#btn-status').click(function() {
            $('#status').modal('hide');
        })
    })
</script>
<?php if ($status == true) : ?>
    <script>
        $('#status').modal('show');
    </script>
<?php endif; ?>