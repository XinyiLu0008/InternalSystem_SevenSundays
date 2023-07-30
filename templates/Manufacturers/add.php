<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Manufacturer $manufacturer
 */
?>

<?php

     $this->Breadcrumbs->add([
         [
             'title' => 'Dashboard',
             'url' => ['controller' => 'users', 'action' => 'user_profile'],
             'options' => ['class' => 'breadcrumb-item']
         ]]);


     $this->Breadcrumbs->add([
            [
                  'title' => 'Manufacturers',
                  'url' => ['controller' => 'manufacturers', 'action' => 'index'],
                  'options' => ['class' => 'breadcrumb-item'],
              ],
            [
                  'title' => 'Add a New Manufacturer',
                  'options' => ['class' => 'breadcrumb-item active',
                  ],
              ],
     ]);

    $this->Breadcrumbs->setTemplates([
           'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
       ]);


     echo $this->Breadcrumbs->render(); ?>

 <?php
echo $this->Html->css('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', ['block' => true]);
echo $this->Html->script('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['block' => true]);
?>


<div class="container-fluid">

    <div class="column-responsive column-80">
        <div class="manufacturers form content">
            <?= $this->Form->create($manufacturer) ?>
          <h2 class="d-block" style="font-size: 1.5rem; color: #5D51AF; font-weight: bold">
                              Add a New Manufacturer</h2>

               <fieldset class="text-primary" style="width:90%; margin:auto ">

                                Business
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-6 mb-sm-0">
                                        <?php
                                        echo $this->Form->control('name' , ['class'=> 'form-control']); ?>
                                    </div>


                                    <div class="col-sm-6 mb-4 mb-sm-0">
                                        <?php echo $this->Form->control('country', [
                                        'class' => 'form-control', 'type' => 'select', 'options' => $countries, 'default'=>'Australia', 'empty' => false
                                        ]); ?>
                                    </div>
                                </div>
                                    <div class="form-group row">
                                    <div class="col-sm-4 mb-4 mb-sm-0">
                                        <?php echo $this->Form->control('products_type' , ['class'=> 'form-control']); ?>
                                    </div>
                                </div>

                                Contact
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <?php
                                        echo $this->Form->control('primary_contact_name' , ['class'=> 'form-control']); ?>
                                    </div>


                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <?php echo $this->Form->control('email', ['class'=> 'form-control', 'type' => 'email']); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <?php echo $this->Form->control('phone', ['class'=> 'form-control', 'type' => 'tel']); ?>
                                    </div>
                                </div>

                        </fieldset>
               <div class="row" style="width: 60%; margin: auto">
                             <div class="col-lg-6  mx-auto ">
                                 <?= $this->Form->button(__('Submit'), ['style'=>'width: 90%', 'padding: 10%' , 'class' => 'btn btn-outline-info my-2 my-sm-0']) ?>
                                 <?= $this->Form->end() ?>
                             </div>

                             <div class="col-lg-6 mx-auto ">
                                 <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['style'=>'width: 90%','confirm' => __('Are you sure you want to cancel adding a manufacturer?'),
                                     'class' => ' button float-left  btn btn-danger']) ?>
                                 <br>
                                 <br>

                             </div>

                         </div>

        </div>

    </div>

</div>

<script>
    $(document).ready(function() {
        $('#country').select2();
    });
</script>


