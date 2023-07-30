<?php
$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'user_profile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);

$this->Breadcrumbs->add([

    [
        'title' => 'Notifications',
        'options' => ['class' => 'breadcrumb-item active',
        ],
    ],
]);

$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',
]);


echo $this->Breadcrumbs->render(); ?>

<title>
    Notifications
</title>
<span></span>
<div class="container-fluid">
    <?= $this
        ->Flash
        ->render() ?>
</div>
