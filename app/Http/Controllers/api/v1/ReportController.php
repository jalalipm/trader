<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockDataRequest;
use App\Model\PortfolioManagement;
use App\Model\StockData;
use App\Model\UserFinanceHistory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // public function cost_benefit_by_portfolio_report(Request $request)
    // {
    //     $user_id = Auth()->user()->id;
    //     $portfolio_management_id = $request->json()->get('portfolio_management_id');
    //     $start_date = $request->json()->get('start_date');
    //     $end_date = $request->json()->get('end_date');

    //     $data = UserFinanceHistory::CostBenefitReport()
    //         ->where('user_id', $user_id)
    //         ->where('portfolio_management_id', $portfolio_management_id)
    //         ->whereRaw("trade_date >= '$start_date' and trade_date <= '$end_date'")
    //         ->get();
    //     $data = [
    //         'cost_benefit_by_portfolio_report' => $data
    //     ];
    //     return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    // }


    public function cost_benefit_report(Request $request)
    {
        $user_id = Auth()->user()->id;
        $portfolio_management_id = $request->json()->get('portfolio_management_id');
        $start_date = $request->json()->get('start_date');
        $end_date = $request->json()->get('end_date');

        $data = UserFinanceHistory::CostBenefitReport()
            ->where('user_id', $user_id)
            ->where('portfolio_management_id', $portfolio_management_id)
            ->whereRaw("trade_date >= '$start_date' and trade_date <= '$end_date'")
            ->get();
        $data = [
            'cost_benefit_report' => $data
        ];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    /*
    function curl_initialize($methode_name, $host, $url, $input_arr)
    {
        $curl = curl_init();
        $input_str = null;
        foreach ($input_arr as $item) {
            $input_str .= " <" . $item['name'] . ">" . $item['value'] . "</" . $item['name'] . ">\n ";
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">
                <soap:Body>
                        <" . $methode_name . " xmlns=\"http://tempuri.org/\">\n" . $input_str . "</" . $methode_name . ">
                </soap:Body>
            </soap:Envelope>",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/xml",
                "SOAPAction: \"http://tempuri.org/" . $methode_name . "\"",
                "Host:" . $host,
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $your_xml_response = $response;
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $your_xml_response);
        $xml = simplexml_load_string($clean_xml);
        return $xml;
    }

    public function call_method()
    {
        try {
            $result = $this->curl_initialize(
                'GetOneGoods',
                '185.120.250.241',
                'http://185.120.250.241:8686/FiorehWebService/WebService.asmx',
                [
                    ["name" => 'token', 'value' => 'be4152495c7b778b1f62c55228a8dcb4'],
                    ["name" => 'ip', 'value' => 'IP'],
                    ["name" => 'barcode', 'value' => '2000006']
                ]
            );
            dd(json_decode($result->Body->GetOneGoodsResponse->GetOneGoodsResult, true));

            // return $this->import_goods_all(
            //     json_decode($result->Body->SepareshGoodsListResponse->SepareshGoodsListResult, true),
            //     $employer->id
            // );
        } catch (\Exception $e) {
        }
    }
    */
}
