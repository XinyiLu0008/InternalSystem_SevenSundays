<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inventory[]|\Cake\Collection\CollectionInterface $inventories
 */

use Cake\I18n\FrozenTime;

?>

<?php
$userRole = $this->Identity->get('role');

if (($userRole === 'admin') || ($userRole === 'staff')) {
    $this->Breadcrumbs->add([
        [
            'title' => 'Dashboard',
            'url' => ['controller' => 'users', 'action' => 'user_profile'],
            'options' => ['class' => 'breadcrumb-item']
        ]]);

    $this->Breadcrumbs->add([
        [
            'title' => 'Inventory',
            'url' => ['controller' => 'inventories', 'action' => 'index'],
            'options' => ['class' => 'breadcrumb-item '],
        ]]);

    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
    ]);

}
echo $this->Breadcrumbs->render();

?>

<?= $this->Html->css('/vendor/datatables/dataTables.bootstrap4.css', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]); ?>


<!--$this->Html->css('/vendor/datatables/buttons.dataTables.min.css' , ['block' => true]); -->

<?= $this->Html->script('/vendor/datatables/dataTables.buttons.min.js', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/jszip.min.js', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/pdfmake.min.js', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/vfs_fonts.js', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/buttons.html5.min.js', ['block' => true]); ?>
<?= $this->Html->script('/vendor/datatables/buttons.print.min.js', ['block' => true]); ?>
<!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" type="text/javascript"></script>-->
<!--$this->Html->script('/vendor/datatables/buttons.colVis.min.js', ['block' => true]);-->

<div class="container-fluid">

    <!--Drop down accordion for notifications -->
    <div class="" id="accordion">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                   aria-expanded="true" aria-controls="collapseOne">
                    Notifications
                    <div style=" float: right; " class="col-auto">
                        <i class="fa fa-angle-down fa-2x"></i>
                    </div>
                </a>
            </h6>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <?= $this->Flash->render('low_stock') ?>
            </div>
        </div>
    </div>

    <!--    Drop down accordion for import  -->
    <div class="" id="accordion">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                   aria-expanded="true" aria-controls="collapseTwo">
                    Import Inventory Items
                    <div style="float: right; " class="col-auto">
                        <i class="fa fa-angle-down fa-2x"></i>
                    </div>
                </a>
            </h6>
        </div>

        <div id="collapseTwo" data-parent="#accordion" class="collapse  aria-labelledby="headingOne">
            <div class="card-body">
                <div class="import excel file" style="padding: 15px">

                    <?= $this->Form->create($model = null, ['type' => 'file', 'url' => ['action' => 'importsexcel']]) ?>

                    <?php
                    echo $this->Form->control('excel', ['type' => 'file', 'required' => true,  'label' => false, 'class' => '']);
                    ?> <br>


                    <?= $this->Form->button(__('Import'), ['class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                    <?= $this->Form->end() ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="inventories index content">


        <?= $this->Html->link(__('Add an Inventory Item'), ['action' => 'add'],
            ['class' => 'button float-right  btn btn-sm btn-primary shadow-sm', 'style' => 'margin: 15px']) ?>
        <?= $this->Html->link(__('Deduct Inventory Quantity'), ['action' => 'bulk_deduct'], ['style' => 'margin: 15px', 'class' => 'button float-right  btn btn-sm btn-primary shadow-sm']) ?>
        <br>
        <h3><?= __('Inventory') ?></h3>


        <div class="card shadow mb-4 ">
            <div class="card-header py-3 d-flex">
                <?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline my-2 my-lg-0']) ?>
                <?= $this->Form->input('key', ['label' => 'Search', 'class' => 'form-control mr-sm-2', 'value' => $this->request->getQuery('key')]) ?>
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
                <?= $this->Form->end() ?>
            </div>
        </div>


        <div class="table-responsive">
            <?= $this->Form->create(null, ['url' => ['action' => 'deleteAll']]) ?>
            <button onclick="return confirm('Are you sure you want to delete all selected Inventory Items?')" class="button float-right  btn btn-sm btn-danger shadow-sm ">Delete All   <i class="fas fa-trash-alt"></i> </button>


            <table class="table table-bordered table-hover" id="example" width="100%" cellspacing="0">

                <thead>
                <tr>
                    <th>#</th>
                    <th><?= $this->Paginator->sort('id', 'Batch No.') ?></th>

                    <th><?= $this->Paginator->sort('product_id') ?></th>

                    <th><?= $this->Paginator->sort('received_date') ?></th>
                    <th><?= $this->Paginator->sort('expiry_date') ?></th>

                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('sku') ?></th>
                    <th><?= $this->Paginator->sort('shelf_life') ?></th>

                    <th><?= $this->Paginator->sort('Packaged') ?></th>

                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($inventories as $inventory): ?>
                    <tr>
                        <td><?= $this->Form->checkbox('id[]', ['value' => $inventory->id]) ?></td>
                        <td><?= h($inventory->id) ?></td>
                        <td style=" font-size: 15px; font-weight: bold "><?= $inventory->has('product') ? $this->Html->link($inventory->product->title,
                                ['controller' => 'Products', 'action' => 'view', $inventory->product->id]) : '' ?></td>

                        <td><?= h($inventory->received_date) ?></td>

                        <?php $NewDate = new FrozenTime('6 month', 'Australia/Melbourne');
                        $currentTime = FrozenTime::now('Australia/Melbourne');
                        if (isset($inventory->expiry_date) && $inventory->expiry_date < $NewDate && $inventory->expiry_date > $currentTime) {
                            ?>
                            <td style="color: orange"><?= h($inventory->expiry_date) ?></td>
                        <?php } else if ($inventory->expiry_date <= $currentTime) { ?>
                            <td style="color: red"><?= h($inventory->expiry_date) ?></td>
                        <?php } else { ?>
                            <td><?= h($inventory->expiry_date) ?></td>
                        <?php } ?>

                        <td><?= $this->Number->format($inventory->quantity) ?></td>
                        <td><?= $inventory->has('product') ? $inventory->product->sku : '' ?></td>
                        <td><?= $inventory->has('product') ? $inventory->lifetime : '' ?> years</td>


                        <td class="gotoCheck">
                            <input type="checkbox" <?php if ($inventory->checkbox): ?> checked="checked" <?php endif; ?>
                                   value="<?= $inventory->id ?>"/>
                        </td>


                        <td class="actions">
                            <?= $this->Html->link("<span class=\"fas fa-eye\"></span>" . __(' View'), ['action' => 'view', $inventory->id],
                                ['escape' => false, 'title' => __('View'), 'class' => 'btn btn-success btn-sm']) ?>

                            <?= $this->Html->link("<span class=\"fas fa-edit\"></span>" . __(' Update'), ['action' => 'edit', $inventory->id],
                                ['escape' => false, 'title' => __('Update'), 'class' => 'btn btn-warning btn-sm']) ?>

                            <?= $this->Form->postLink("<span class=\"fas fa-trash\"></span>" . __(' Delete'), ['action' => 'delete', $inventory->id],
                                ['confirm' => __('Are you sure you want to delete the inventory record of batch # {0}?', $inventory->id), 'escape' => false, 'title' => __('Delete'), 'class' => 'btn btn-danger btn-sm']) ?>

                            <?php $orderStatus = $inventory->received_date;
                            if (empty($orderStatus)) { ?>
                                <?= $this->Form->postLink("<span class=\"fas fa-check\"></span>" . __(' Confirm'), ['action' => 'confirm', $inventory->id],
                                    ['confirm' => __('Confirming that the order of {0}  has been received)?', $inventory->product->title), 'escape' => false, 'title' => __('Confirm'), 'class' => 'btn btn-primary btn-sm']) ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?= $this->Form->end() ?>
        </div>

<!--        Paging Stylings -->
        <div class="" style="text-align: center; padding: 1%">
            <ul class="pagination justify-content-center">
                <?php $this->Paginator->setTemplates([
                    'first' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                    'prevActive'=>'<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'prevDisabled'=>'<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                    'number'=>'<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'current'=>'<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'nextActive'=>'<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                    'nextDisabled'=>'<li class="page-item disabled"><a onclick="return false" class="page-link" href="{{url}}">{{text}}</a></li>',
                    'last' => '<li class="page-item">
                                                    <a class="page-link" href="{{url}}" >
                                                    <span aria-hidden="true">{{text}}</span>
                                                  </a>
                                                </li>',
                ]);?>

                <?= $this->Paginator->prev( __('Previous')) ?>

                <div class="form-group row" style="padding-left: 10px; padding-right: 10px">
                <?= $this->Paginator->numbers() ?>
                </div>

                <?= $this->Paginator->next(__('Next') ) ?>


            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('.gotoCheck').on('click', function (obj) {
                var data;
                if (obj.target.value) {
                    data = 'vid=' + obj.target.value;
                    if ($(obj.target).is(':checked')) {
                        data += "&add=" + 1;
                    } else {
                        data += "&add=" + 2;
                    }
                } else {
                    var checkInput = $(obj.target).find('input[type!=hidden]');
                    data = 'vid=' + checkInput[0].value;
                    if ($(checkInput[0]).is(':checked')) {
                        $(checkInput[0]).removeAttr('checked');
                        data += "&add=" + 2;
                    } else {
                        data += "&add=" + 1;
                        $(checkInput[0]).attr('checked', true)
                    }
                }

                console.log(data);

                var url = '/team073-app_fit3048/inventories/modifyCheckbox';
                $.ajax({
                    url: url,
                    data: data,
                    type: 'get',
                    success: function () {

                    },
                    error: function () {

                    }
                });
            })
        });

        $(document).ready(function () {
            // $('#example').DataTable( {
            //     dom: 'Bfrtip',
            //     buttons: [
            //         'copy', 'csv', 'excel', 'pdf', 'print'
            //     ],
            // } );

            $('#example').DataTable({
                "paging": false,
                "ordering": true,
                "info": false,
                "searching": false,
                "autoFill": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                // responsive: true,

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [  1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [  1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [  1, 2, 3, 4, 5, 6, 7 ]
                        },
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [  1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                ],
            });

            $('#exportcsv').on('click', function () {
                $('.buttons-csv').click()
            });
            $('#exportexcel').on('click', function () {
                $('.buttons-excel').click()
            });
            $('#exportpdf').on('click', function () {
                $('.buttons-pdf').click()
            });
            $('#exportprint').on('click', function () {
                $('.buttons-print').click()
            });


        });

    </script>

