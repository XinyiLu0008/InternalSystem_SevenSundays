<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<?php
$userRole = $this->Identity->get('role');

if (($userRole === 'admin')) {
 if ( isset($key) && isset($params['id'])) { ?>

    <div id="flash-<?= h($key) ?>" class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <a href="<?php echo $this->Url->build(['controller' => 'Inventories', 'action' => 'view', h($params['id'])]) ?>">
            <?= h($message) ?> </a> </div>

<?php } elseif (isset($params['packaging'])) {?>

    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <a href="<?php echo $this->Url->build(['controller' => 'Packagings', 'action' => 'view', h($params['packaging'])]) ?>">
            <?= h($message) ?> </a> </div>

<?php }

 elseif (isset($params['product'])) {?>

    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <a href="<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'view', h($params['product'])]) ?>">
            <?= h($message) ?> </a> </div>

<?php } else { ?>
        <div class="alert alert-danger alert-dismissable " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= strip_tags($message, '<br>') ?>
    </div>
     <?php
 }

}
else { ?>

    <div class="alert alert-danger alert-dismissable " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?= strip_tags($message, '<br>') ?>
    </div>

<?php } ?>
