<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!--<div class="--><?//= h($class) ?><!--" onclick="this.classList.add('hidden');">--><?//= $message ?><!--</div>-->
<div class="alert  alert-dismissable " role="alert" style="color: white;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?= strip_tags($message, '<br>') ?>
</div>
