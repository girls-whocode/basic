<?php
  use yii\helpers\Html;
  use yii\widgets\LinkPager;

  $this->title = 'Bills';
  $this->params['breadcrumbs'][] = $this->title;

  // cents: 0=never, 1=if needed, 2=always
  function formatMoney($number, $cents = 2) { 
    if (is_numeric($number)) {
      if (!$number) {
        $money = ($cents == 2 ? '0.00' : '0');
      } else {

        if (floor($number) == $number) {
          $money = number_format($number, ($cents == 2 ? 2 : 0));
        } else {
          $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2));
        }
      }
      return '$'.$money;
    }
  }
?>

<div class="site-bills">
  <h1><?= Html::encode($this->title) ?></h1>
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
        <td><?= $bill['type_name'] ?></td>
        <td><?= $bill['bill_autopay'] == '1' ? true : false ?></td>
        <td><?= formatMoney($bill['bill_credit']) ?></td>
        <td><?= formatMoney($bill['bill_balance']) ?></td>
        <td><?= formatMoney($bill['bill_payment']) ?></td>
        <td><?= $bill['bill_dueday'] ?></td>
        <td><?= $bill['bill_rate'] ?></td>
        <td><?= $bill['bill_cpi'] == '1' ? true : false ?></td>
        <td><?= formatMoney($bill['bill_perid']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>