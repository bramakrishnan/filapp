<?php

namespace filter\flex;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\ForecastedRecord;

/**
 * This is just an example.
 */
class CommonFilter extends \yii\base\Widget {

    public $country;
    public $market;
    public $region;
    public $plant;
    public $global_pm;
    public $customer;
    public $version;
    public $globalcustlead;
    public $account_manager;
    public $nameplate;
    public $sitepm;

    public function run() {
        
//        echo '<pre>'; print_r(Yii::$app->request->get()); die;
        
        if(Yii::$app->request->get()){
            $Params =   Yii::$app->request->get();
            $this->country  =   (isset($Params['country']))?$Params['country']:'';
            $this->market  =   (isset($Params['market']))?$Params['market']:'';
            $this->region  =   (isset($Params['region']))?$Params['region']:'';
            $this->plant  =   (isset($Params['palnt']))?$Params['palnt']:'';
            $this->customer  =   (isset($Params['customer']))?$Params['customer']:'';
            $this->global_pm  =   (isset($Params['glopalpm']))?$Params['glopalpm']:'';
            $this->version  =   (isset($Params['version']))?$Params['version']:'';
            $this->globalcustlead  =   (isset($Params['globallead']))?$Params['globallead']:'';
            $this->account_manager  =   (isset($Params['accmanager']))?$Params['accmanager']:'';
            $this->nameplate  =   (isset($Params['nameplate']))?$Params['nameplate']:'';
            $this->sitepm  =   (isset($Params['sitepm']))?$Params['sitepm']:'';
        }
        
        $QueryObj = (new \yii\db\Query());
        $forecast_data = $QueryObj->select(['country', 'market', 'region','name_plate'])->from('current_forecasted_record')->all();
        $getCountryList = ArrayHelper::map($forecast_data, 'country', 'country');
        $getMarketList = ArrayHelper::map($forecast_data, 'market', 'market');
        $getRegiontList = ArrayHelper::map($forecast_data, 'region', 'region');
        $getNamePlateList = ArrayHelper::map($forecast_data, 'name_plate', 'name_plate');

        $getPlantList = ArrayHelper::map($QueryObj->select(['plant_name'])->from('plant')->all(), 'plant_name', 'plant_name');
        $getCustomerList = ArrayHelper::map($QueryObj->select(['global_customer_name'])->from('customer')->all(), 'global_customer_name', 'global_customer_name');
        $teamDataList = $QueryObj->select(['global_program_manager', 'global_customer_lead','account_manager'])->from('current_team_data')->all();

        $getGlobalPmList = ArrayHelper::map($teamDataList, 'global_program_manager', 'global_program_manager');
        $getGlobalCustLeadList = ArrayHelper::map($teamDataList, 'global_customer_lead', 'global_customer_lead');
        $getAccManagerList = ArrayHelper::map($teamDataList, 'account_manager', 'account_manager');
        $getSitetPMList = ArrayHelper::map($teamDataList, 'site_program_manager', 'site_program_manager');

        $miscDataList = $QueryObj->select(['version'])->from('current_misc_data')->all();
        $getVersionList = ArrayHelper::map($miscDataList, 'version', 'version');
        

        return $this->render('@app/views/common/filter', [
                    'country_value' => $this->country,
                    'market_value' => $this->market,
                    'region_value' => $this->region,
                    'plant_value' => $this->plant,
                    'customer_value' => $this->customer,
                    'globalpm_value' => $this->global_pm,
                    'version_value' => $this->version,
                    'globalcustlead_value' => $this->globalcustlead,
                    'accManager_value' => $this->account_manager,
                    'nameplate_value' => $this->nameplate,
                    'sitepm_value' => $this->sitepm,
                    'country_list' => $getCountryList,
                    'getMarketList' => $getMarketList,
                    'getRegiontList' => $getRegiontList,
                    'getPlantList' => $getPlantList,
                    'getCustomerList' => $getCustomerList,
                    'getGlobalPmList' => $getGlobalPmList,
                    'getVersionList' => $getVersionList,
                    'getGlobalCustLeadList' => $getGlobalCustLeadList,
                    'getAccManagerList' => $getAccManagerList,
                    'getNamePlateList' => $getNamePlateList,
                    'getSitetPMList' => $getSitetPMList,
                    'isFilter' => $this->isFilter()
        ]);
    }

    public function isFilter() {
        $is_filter = false;
        foreach ($this as $value) {
            if ($value != "")
                $is_filter = true;
        }
        return $is_filter;
    }

}
