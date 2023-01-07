<?php
  use yii\helpers\Html;
  use yii\widgets\LinkPager;

  $this->title = 'Companies';
  $this->params['breadcrumbs'][] = $this->title;

  function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
}
?>

<div class="site-companies">
  <h1><?= Html::encode($this->title) ?></h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Creditor Name</th>
        <th scope="col">Company Name</th>
        <th scope="col">Company Address</th>
        <th scope="col">Company Phone</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($companies as $company): ?>
      <tr>
        <td scope="row"><?= $company['company_name'] ?></td>
        <td><a href="<?= $company['company_website'] ?>" target="_blank"><?= $company['company_credit_name'] ?></a></td>
        <td>
          <?= $company['company_address'] != "" ? $company['company_address'] : "Address not entered" ?>
          <?= $company['company_city'] != "" ? $company['company_city']."," : "" ?>
          <?= $company['company_state'] != "" ? $company['company_state'] : "" ?>
          <?= $company['company_zip'] != "" ? $company['company_zip'] : "" ?>
        </td>
        <td><?= formatPhoneNumber($company['company_phone']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
