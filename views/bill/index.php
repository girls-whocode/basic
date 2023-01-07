<?php
  use yii\helpers\Html;
  use kartik\icons\Icon;
  use yii\widgets\LinkPager;
  use yii\console\widgets\Table;
  use yii\widgets\ActiveForm;
  use wbraganca\dynamicform\DynamicFormWidget;
 
  $this->title = 'Bills';
  $this->params['breadcrumbs'][] = $this->title;

  Icon::map($this);
  $table = new Table();

  $js = '
  jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
      jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
          jQuery(this).html("Address: " + (index + 1))
      });
  });
  
  jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
      jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
          jQuery(this).html("Address: " + (index + 1))
      });
  });
  ';
  
  $this->registerJs($js);
?>

<div class="site-bills">
  <h1><?= Html::encode($this->title) ?></h1>

  <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Creditor Name</th>
        <th scope="col">Company Name</th>
        <th scope="col">Bill Type</th>
        <th scope="col">Autopay</th>
        <th scope="col">Credit</th>
        <th scope="col">Balance</th>
        <th scope="col">Payment</th>
        <th scope="col">Due Date</th>
        <th scope="col">Interest Rate</th>
        <th scope="col">CPI Amount</th>
        <th scope="col">CPI Per</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($bills as $bill): ?>
      <tr>
        <th scope="row"><?= $bill['company_name'] ?></th>
        <td><a href="<?= $bill['company_website'] ?>" target="_blank"><?= $bill['company_credit_name'] ?></a></td>
        <td class="text-center"><?= $bill['type_name'] == 'credit' ? Icon::show('credit-card', ['class'=>'fa-2x']) : Icon::show('file-invoice-dollar', ['class'=>'fa-2x']) ?></td>
        <td class="text-center"><?= $bill['bill_autopay'] == '1' ? Icon::show('toggle-on', ['class'=>'fa-2x, toggle-on']) : Icon::show('toggle-on', ['class'=>'fa-2x, toggle-off']) ?></td>
        <td><?= formatMoney($bill['bill_credit']) ?></td>
        <td><?= formatMoney($bill['bill_balance']) ?></td>
        <td><?= formatMoney($bill['bill_payment']) ?></td>
        <td><?= $bill['bill_dueday'] ?></td>
        <td><?= $bill['bill_rate'] ?>%</td>
        <td><?= $bill['bill_cpi'] == '1' ? true : false ?></td>
        <td><?= formatMoney($bill['bill_perid']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php ActiveForm::end(); ?>
</div>