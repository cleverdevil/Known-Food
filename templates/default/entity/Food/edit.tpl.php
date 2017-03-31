<?= $this->draw('entity/edit/header'); ?>
<?php

    $autosave = new \Idno\Core\Autosave();
    if (!empty($vars['object']->body)) {
        $body = $vars['object']->body;
    } else {
        $body = $autosave->getValue('food', 'bodyautosave');
    }
    if (!empty($vars['object']->title)) {
        $title = $vars['object']->title;
    } else {
        $title = $autosave->getValue('food', 'title');
    }
    if (!empty($vars['object']->category)) {
        $category = $vars['object']->category;
    } else {
        $category = $autosave->getValue('food', 'category');
    }
    if (!empty($vars['object'])) {
        $object = $vars['object'];
    } else {
        $object = false;
    }

    /* @var \Idno\Core\Template $this */

?>
    <form action="<?= $vars['object']->getURL() ?>" method="post" enctype="multipart/form-data">

        <div class="row">

            <div class="col-md-8 col-md-offset-2 edit-pane">


                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <h4>Log Food or Drink</h4>
                    <?php

                    } else {

                        ?>
                        <h4>Edit Log</h4>
                    <?php

                    }

                ?>

                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <div id="photo-preview"></div>
                        <p>
                                <span class="btn btn-primary btn-file">
                                        <i class="fa fa-camera"></i> <span
                                        id="photo-filename">Select a photo</span> <input type="file" name="photo"
                                                                                         id="photo"
                                                                                         class="col-md-9 form-control"
                                                                                         accept="image/*;capture=camera"
                                                                                         onchange="photoPreview(this)"/>

                                    </span>
                        </p>

                    <?php

                    }

                ?>
                <div class="content-form">

                    <style>
                        .category-block {
                            margin-bottom: 1em;
                        }
                    </style>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="What did you eat or drink?" value="<?= htmlspecialchars($title) ?>" class="form-control"/>                    
                    
                    <!-- styled category -->
                    <label for="category">Category</label>
                    <div class="category-block">
                        <input type="hidden" name="category" id="category-id" value="<?= $category ?>">
                        <div id="category" class="category">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle category" data-toggle="dropdown" href="#" id="category-button" aria-expanded="false">
                                    <i class="fa fa-cutlery"></i> Ate <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-category="ate" class="category-option"><i class="fa fa-cutlery"></i> Ate </a></li>
                                    <li><a href="#" data-category="drank" class="category-option"><i class="fa fa-glass"></i> Drank </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <style>
                        a.category {
                            background-color: #fff;
                            background-image: none;
                            border: 1px solid #cccccc;
                            box-shadow: none;
                            text-shadow: none;
                            color: #555555;
                        }

                        .category .caret {
                            border-top: 4px solid #555;
                        }
                    </style>
                    <script>
                        $(document).ready(function () {
                            $('.category-option').each(function () {
                                if ($(this).data('category') == $('#category-id').val()) {
                                    $('#category-button').html($(this).html() + ' <span class="caret"></span>');
                                }
                            })
                        });
                        $('.category-option').on('click', function () {
                            $('#category-id').val($(this).data('category'));
                            $('#category-button').html($(this).html() + ' <span class="caret"></span>');
                            $('#category-button').click();
                            return false;
                        });
                       
                        $('#category-id').on('change', function () {
                        });
                    </script>
                    <!-- end styled category -->
                </div>
                
                <label for="body">Details</label>
                <?= $this->__([
                    'name' => 'body',
                    'value' => $body,
                    'object' => $object,
                    'wordcount' => true
                ])->draw('forms/input/richtext')?>
                <?= $this->draw('entity/tags/input'); ?>

                <?php if (empty($vars['object']->_id)) echo $this->drawSyndication('article'); ?>
                <?php if (empty($vars['object']->_id)) { ?><input type="hidden" name="forward-to" value="<?= \Idno\Core\site()->config()->getDisplayURL() . 'content/all/'; ?>" /><?php } ?>
                
                <?= $this->draw('content/access'); ?>

                <p class="button-bar ">
	                
                    <?= \Idno\Core\site()->actions()->signForm('/food/edit') ?>
                    <input type="button" class="btn btn-cancel" value="Cancel" onclick="tinymce.EditorManager.execCommand('mceRemoveEditor',true, 'body'); hideContentCreateForm();"/>
                    <input type="submit" class="btn btn-primary" value="Publish"/>

                </p>

            </div>

        </div>
    </form>

    <script>
        //if (typeof photoPreview !== function) {
        function photoPreview(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#photo-preview').html('<img src="" id="photopreview" style="display:none; width: 400px">');
                    $('#photo-filename').html('Choose different photo');
                    $('#photopreview').attr('src', e.target.result);
                    $('#photopreview').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        //}
    </script>

    <div id="bodyautosave" style="display:none"></div>
<?= $this->draw('entity/edit/footer'); ?>
