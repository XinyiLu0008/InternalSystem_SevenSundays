<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';


?>

<?php
if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'missing_template.php');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
    <strong>SQL Query Params: </strong>
    <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php if ($error instanceof Error) : ?>
    <strong>Error in: </strong>
    <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    $this->end();
endif;
?>
<h2><?= h($message) ?></h2>

<!-- Heading Row-->
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-6">
        <article class="page">

            <h2>Looks like there has been an error, or this page doesn't exist.</h2>
            <br>
            <h3>
                Trying to place an order?
            </h3>

            <p>
                If this error occurred whilst trying to place an order this might be a temporary error. If you think
                your order might have gone through, you should receive a confirmation email within the next few minutes
                (remember to check you spam folder just in case).
            </p>

            <p>
                If the problem persists please <a href="mailto:contact@sevensundays.com" class="blue">get in contact</a>,
                we'd be happy to try and help.
            </p>
            <h2>
                If all else fails
            </h2>
            <p>Try going back to our  <?= $this->Html->link(__('Home Page'),['controller' => 'users','action' => 'login']) ?>
                and start again - sorry for any inconvenience!</p>
        </article>
        <h1>
            <?= $this->Html->link(__('Back'), 'javascript:history.back()',['class' => 'btn btn-primary']) ?>
        </h1>
    </div>

    <div class="col-lg-6">
        <div class="text-center">
            <?php echo $this->Html->image('SevenSundaysDetailedLogo.png', array('alt' => 'Seven Sundays Detailed Logo'))?>
        </div>
    </div>
</div>

<br>

