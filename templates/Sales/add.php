<?php
/**
 * @var AppView $this
 * @var Sale $sale
 * @var CollectionInterface|string[] $users
 * @var CollectionInterface|string[] $products
 */

use App\Model\Entity\Sale;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$userRole = $this
    ->Identity
    ->get('role');

$params = $this->request->getParam('pass');

if ($userRole === 'customer') {
    $this->layout = 'customerLayout';
}

?>

<?php
if ($userRole === 'admin') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

    $this->Breadcrumbs->add([
        [
            'title' => 'Sales',
            'url' => ['controller' => 'sales', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
    $this->Breadcrumbs->add([
        [
            'title' => 'Order Info',
            'url' => ['controller' => 'sales', 'action' => 'add'],
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
}
if ($userRole === 'customer') {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'retailer_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

    $this->Breadcrumbs->add([
        [
            'title' => 'Place Order',
            'url' => ['controller' => 'sales', 'action' => 'add'],
            'options' => ['class' => 'breadcrumb-item '],
        ]]);
}


$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render(); ?>

<?php
if ($userRole === 'admin') { ?>

    <div class="container-fluid">

        <div class="column-responsive column-80">
            <div class="sales form content">
                <?= $this->Form->create($sale) ?>

                <h2 class="d-block" style="font-size: 1.5rem;color: #5D51AF; font-weight: bold">Please Fill the Order Details</h2>
                <fieldset class="text-primary" style="width:90%; margin:auto ">

                    Purchase
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-6 mb-sm-0">
                            <?php
                            echo $this->Form->control('product_id', ['options' => $products, 'class' => 'form-control']); ?>
                        </div>


                        <div class="col-sm-4 mb-4 mb-sm-0">
                            <?php echo $this->Form->control('quantity', ['min' => '1', 'max' => '1000000', 'class' => 'form-control']); ?>
                        </div>

                        <div class="col-sm-4 mb-4 mb-sm-0">
                            <?php echo $this->Form->control('price', ['min' => '1', 'max' => '1000000', 'type' => 'hidden', 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    Sale Details
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-6 mb-sm-0">
                            <?php
                            echo $this->Form->control('status', ['class' => 'form-control', 'type' => 'select', 'options' => [
                                'pending' => 'Pending',
                                'shipped' => 'Shipped',
                                'cancelled' => 'Canceled',
                                'requested' => 'Requested',
                                'rejected' => 'Rejected',
                                'returned' => 'Returned',
                            ]]); ?>
                        </div>

                        <div class="col-sm-4 mb-4 mb-sm-0">

                            <?php echo $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control', 'required' => true, 'label' => 'Retailer']); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-4 mb-sm-0">
                            <?php echo $this->Form->control('sales_date', ['class' => 'form-control']); ?>
                        </div>


                    </div>

                </fieldset>
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Form->button(__('Submit'), ['style' => 'width: 90%', 'padding: 10%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>


                        <?= $this->Form->end() ?>
                    </div>

                    <div class="col-lg-6 mx-auto ">
                        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                        <br>
                        <br>
                    </div>

                </div>

                <div id="showMsg" style="display: none; width: 300px; height: 100px;">
                    <label id="errorMsg"></label>
                </div>

            </div>
        </div>
    </div>
<?php } else if ($userRole === 'customer') { ?>

    <div class="container-fluid">

        <div class="column-responsive column-80">
            <div class="sales form content">
                <?= $this->Form->create($sale) ?>
                <fieldset style="width:90%; margin:auto">
                    <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">Please
                            fill the order detail</h2>

                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('quantity', ['min' => '1', 'max' => '1000000', 'class' => 'form-control']); ?>

                        </div>

                        <div class="col-sm-3">
                            <?php
                            if (isset($params[0])) {
                                echo $this->Form->control('product_id', ['options' => $products, 'default' => $params[0], 'class' => 'form-control']);
                            } else {
                                echo $this->Form->control('product_id', ['options' => $products, 'class' => 'form-control']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <?php
                            echo $this->Form->control('sales_date', ['default' => $time, 'readonly' => 'readonly', 'class' => 'form-control']); ?>

                        </div>
                    </div>

                    <?php
                    echo $this->Form->control('status', ['class' => 'form-control', 'default' => 'pending', 'type' => 'hidden']); ?>  <?php
                    echo $this->Form->control('user_id', ['class' => 'form-control', 'default' => $userID, 'type' => 'hidden']); ?>
                    <br>
                </fieldset>
                <div class="row" style="width: 60%; margin: auto">
                    <div class="col-lg-6  mx-auto ">
                        <?= $this->Form->button(__('Submit'), ['style' => 'width: 90%', 'padding: 10%', 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="col-lg-6 mx-auto ">
                        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style' => 'width: 90%', 'confirm' => __('Are you sure you want to cancel'), 'class' => ' button float-left  btn btn-danger']) ?>
                        <br>
                        <br>
                    </div>

                </div>

            </div>
        </div>
    </div>

<?php } ?>
