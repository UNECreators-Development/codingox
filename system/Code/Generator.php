<?php
defined('APP_PATH') or exit('No direct script access allowed');

require_once('Controller.php');
require_once('Model.php');
require_once('Form.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") :
    if (isset($_POST['controllerClass'])) :
        if (!file_exists($base_path . 'Controllers/' . ucfirst($_POST['controllerClass']) . '.php')) :
            echo "success";
        else :
            echo "already";
        endif;
        exit();
    endif;

    if (isset($_POST['type'])) :
        if ($_POST['type'] == "controller") :
            if (!empty($_POST['controller']) && !empty($_POST['action']) && !empty($_POST['viewPath'])) :
                controller($_POST['controller'], $_POST['action'], $_POST['viewPath']);
            endif;
        elseif ($_POST['type'] == "form") :
            if (!empty($_POST['viewName']) && !empty($_POST['field']) && !empty($_POST['viewPath'])) :
                form($_POST['viewName'], $_POST['field'], $_POST['viewPath']);
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
    <link href="<?= APP_URL . '/' . APP_PATH; ?>web/system/css/main.css" rel="stylesheet">
    <script src="<?= APP_URL . '/' . APP_PATH; ?>web/system/js/jquery.js"></script>
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
                            <a class="nav-link" href="<?= APP_URL . '/' . APP_PATH; ?>">Application</a>
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
                        <p>This generator generates a view script file that displays a form to collect input for the
                            specified Controller class.</p>
                        <p><a class="btn btn-outline-secondary" href="#form">Start »</a></p>
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
                                    <label class="control-label help" title="This is the name of the controller class to be generated." for="generator-controllerclass">Controller Class</label>
                                    <input type="hidden" name="type" value="controller">
                                    <input type="text" id="generator-controllerclass" class="form-control" name="controller" aria-required="true" required>
                                    <p id="controllerMsg" class="mt-2 text-danger" style="display: none"></p>
                                </div>
                                <div class="form-group field-generator-actions">
                                    <label class="control-label help" title="Provide one or multiple action IDs to generate empty action method(s) in the controller. Separate multiple action IDs with commas or spaces. Action IDs should be in lower case." for="generator-actions">Action IDs</label>
                                    <input type="text" id="generator-actions" class="form-control" name="action" value="index,about" required>
                                </div>
                                <div class="form-group field-generator-viewpath">
                                    <label class="control-label help" data-toggle="popover" title="Specify the directory for storing the view scripts for the controller." data-placement="right" for="generator-viewpath">View Path</label>
                                    <input type="text" id="generator-viewpath" value="views/" class="form-control" name="viewPath" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="btn-controller" disabled class="btn btn-primary" name="preview">Generate</button>
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
                                    <label class="control-label help" title="This is the view name with respect to the view path." for="generator-viewname">View Name</label>
                                    <input type="hidden" name="type" value="form">
                                    <input type="text" id="generator-viewname" class="form-control" name="viewName" aria-required="true" aria-invalid="true" required>
                                </div>
                                <div class="form-group field-generator-modelclass required">
                                    <label class="control-label help" title="This is the form field for collecting the form input." for="generator-modelclass">Form Field</label>
                                    <input type="text" id="generator-modelclass" value="name,number" class="form-control" name="field" aria-required="true" required>
                                </div>
                                <div class="form-group sticky field-generator-viewpath required">
                                    <label class="control-label help" title="This is the root view path to keep the generated view files. You may provide either a directory or a path." for="generator-viewpath">View Path</label>
                                    <input type="text" id="generator-viewpath" class="form-control" name="viewPath" value="views/" aria-required="true" required>
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
                    <p class="text-right">Powered by <a href="http://framework.upgradeads.in" rel="external">CodingOx</a></p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
<script>
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this).attr('href');
        if (target == "#controller") {
            $('#model').hide();
            $('#form').hide();
            $(target).show();
        } else if (target == "#model") {
            $('#controller').hide();
            $('#form').hide();
            $(target).show();
        } else if (target == "#form") {
            $('#controller').hide();
            $('#model').hide();
            $(target).show();
        } else {
            $('#controller').hide();
            $('#model').hide();
            $('#form').hide();
        }
    });
    $(document).ready(function() {
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
    })
</script>