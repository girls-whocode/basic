<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Bill;

class BillController extends Controller
{
    public function actionIndex()
    {
        $bills = $this->queryData();
        return $this->printTable($bills);
    }

    private function queryData()
    {
        $query = (new \yii\db\Query())
            ->select(
                "bill.bill_companyid,
                bill.bill_typeid,
                bill.bill_autopay,
                bill.bill_paperless,
                bill.bill_credit,
                bill.bill_balance,
                bill.bill_payment,
                bill.bill_dueday,
                bill.bill_rate,
                bill.bill_cpi,
                bill.bill_perid,
                company.company_id,
                company.company_name,
                company.company_credit_name,
                company.company_website,
                company.company_address,
                company.company_city,
                company.company_state,
                company.company_zip,
                company.company_phone,
                type.type_id,
                type.type_name")
            ->from('bill')
            ->join('LEFT OUTER JOIN', 'company', 'bill.bill_companyid=company.company_id')
            ->join('LEFT OUTER JOIN', 'type', 'bill.bill_typeid=type.type_id');
        
        $company = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $rows = $company->getModels();
        return $rows;
    }

    private function printTable($data)
    {
        return $this->render('index', [
            'bills' => $data,
        ]);
    }
}