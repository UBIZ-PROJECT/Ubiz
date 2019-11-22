<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 9/17/2019
 * Time: 11:55 PM
 */

namespace App\Http\Controllers\Web;

use App\Model\ContractDetail;
use App\Model\ProductStatus;
use App\Model\Contract;
use App\Exports\ContractExport;


class ContractController
{
    public function contracts()
    {
        try {
            $contract = new Contract();
            $contractData = $contract->getContracts();
            $pagingData = $contract->getPagingInfo();
            $pagingData['page'] = 0;
            return view('contract', ['contracts' => $contractData, 'paging' => $pagingData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail($ctr_id)
    {
        $contract = new Contract();
        $contractData = $contract->getContract($ctr_id);

        if($contractData == null){
            return response()->view('errors.404', [], 404);
        }
        $contractDetail = new ContractDetail();
        $contractDetailData = $contractDetail->getContractDetailsByCtrId($ctr_id);

        $productStatus = new ProductStatus();
        $statusList = $productStatus->getAllStatus();
        return view('contract_detail', [
            'contract' => $contractData,
            'contractDetail' => $contractDetailData,
            'statusList' => convertDataToDropdownOptions($statusList, 'id', 'title')
        ]);
    }

    public function exportContract($ctr_id,$type) {
        $contract = new Contract();
        $contractData = $contract->getContract($ctr_id);
        $contractDetail = new ContractDetail();
        $contractDetailData = $contractDetail->getContractDetailsByCtrId($ctr_id);
//        print_r($contractData); exit;
        $data = new \stdClass();
        $data->tax = number_format($contractData->ctr_tax);
        $data->totalBeforeTax = number_format($contractData->ctr_amount);
        $data->totalAfterTax = number_format($contractData->ctr_amount_tax);
        $data->taxAmount = number_format($contractData->ctr_amount_tax - $contractData->ctr_amount);
        $data->cus_addr = $contractData->cus_addr;
        $data->contact_phone = $contractData->contact_phone;
        $data->contact_rank = $contractData->contact_rank;
        $data->contact_name = $contractData->contact_name;
        $data->cus_fax = $contractData->cus_fax;
        $data->lstData = array();
        foreach ($contractDetailData as $ctrDetail) {
            $innerData = array(
                "unit"=> $ctrDetail->unit,
                "quantity"=> $ctrDetail->quantity,
                "price"=>number_format($ctrDetail->price),
                "amount"=>number_format($ctrDetail->amount)
            );
            if ($ctrDetail->prod_specs) {
                $innerData["spec"] = $ctrDetail->prod_specs;
                $data->prod[] = $innerData;
            } else {
                $innerData["spec"] = $ctrDetail->acce_name;
                $data->acs[] = $innerData;
            }

        }
        $data->lstData = array_merge($data->prod,$data->acs);
        unset($data->prod);
        unset($data->acs);
        $fileName = null;
        if ($type == "huutai") {
            $fileName = "huutai-template-contract.docx";
        } else if ($type == "thaikhuong") {
            $fileName = "thaikhuong-template-contract.docx";
        }
        if ($fileName == null) {
            return response()->view('errors.404', [], 404);
        }

        $contractExport = new ContractExport();
        $contractExport->execute($data, $fileName, $type);
    }
}