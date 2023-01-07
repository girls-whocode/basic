<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Company;

class CompanyController extends Controller
{
    public function actionIndex()
    {
        $companies = $this->queryData();
        return $this->printTable($companies);
    }

    private function queryData()
    {
        $query = (new \yii\db\Query())
            ->select(
                "company.company_id,
                company.company_name,
                company.company_credit_name,
                company.company_website,
                company.company_address,
                company.company_city,
                company.company_state,
                company.company_zip,
                company.company_phone")
            ->from('company');
        
        $company = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $rows = $company->getModels();
        return $rows;
    }

    private function printTable($data)
    {
        return $this->render('index', [
            'companies' => $data,
        ]);
    }
}