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
<!--<div class="message success" onclick="this.classList.add('hidden')">--><?//= $message ?><!--</div>-->
<div class="alert alert-success alert-dismissable" role="alert" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?= strip_tags($message, '<br>') ?>
</div>
