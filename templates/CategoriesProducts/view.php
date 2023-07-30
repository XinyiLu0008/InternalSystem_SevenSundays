<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesProduct $categoriesProduct
 */
?>

<?php

$userRole = $this->Identity->get('role');


if ($userRole === 'admin') {

$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'user_profile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);


$this->Breadcrumbs->add([
    [
        'title' => 'Product Category',
        'url' => ['controller' => 'categoriesProducts', 'action' => 'index'],
        'options' => ['class' => 'breadcrumb-item'],
    ],
    [
        'title' => 'Category Info',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);

echo $this->Breadcrumbs->render(); ?>

<div class="container-fluid">

    <div class="column-responsive column-80">
        <div class="inventories view content">

            <div class="container search-table">
                <div class="inventories view content">

                    <div class="search-list">
                        <div class="userData ml-3">
                            <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">
                                Product Category</h2>


                        </div>


                        <table class="table" id="myTable">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td><h6 style="font-weight:bold;">Category Title</h6></td>
                                <td>  <h6><?= h($categoriesProduct->name) ?></h6>

                                </td>
                            </tr>

                            <tr>
                                <td><h6 style="font-weight:bold;">Category No.</h6></td>
                                <td>  <h6><?= $this->Number->format($categoriesProduct->id) ?></h6>

                                </td>
                            </tr>

                            <tr >
                                <td colspan="1"></td>
                                <td>


                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $categoriesProduct->id],
                                        ['confirm' => __('Are you sure you want to delete the product category of # {0} ?',
                                            $categoriesProduct->name),
                                            'class' => ' button float-left  btn btn-danger']) ?>
                                </td>

                                </form>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
    </div>
</div>
<?php } ?>
