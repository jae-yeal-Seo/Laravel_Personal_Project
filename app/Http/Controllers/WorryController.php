<?php

namespace App\Http\Controllers;

use App\Models\Resolution;
use App\Models\ResolutionHashTag;
use App\Models\Worry;
use App\Models\WorryHashTag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use LengthException;

class WorryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            "worryHashTags" => "required|array",
        ]);
        $today = date("Y-m-d");
        $month = date("Y-m");
        $year = date("Y");

        $worries = new Worry();
        $worries->title = $request->title;
        $worries->content = $request->content;
        $worries->user_id = Auth::user()->id;
        $worries->untilday = $today;
        $worries->untilmonth = $month;
        $worries->untilyear = $year;
        $worries->save();


        $worryHashTagsArray = $request->worryHashTags;

        $length = count($request->worryHashTags);

        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->write($length);


        for ($i = 0; $i < $length; $i++) {
            $worryHashTag = new WorryHashTag();
            $worryHashTag->worry_id = $worries->id;
            $worryHashTag->hashtag = implode('', $worryHashTagsArray[$i]);
            $worryHashTag->save();
        }

        $resolutionNum = array();

        for ($j = 0; $j < count($worryHashTagsArray); $j++) {
            $tags = ResolutionHashTag::where('hashtag', $worryHashTagsArray[$j])->get();
            for ($k = 0; $k < $tags->count(); $k++) {
                array_push($resolutionNum, $tags[$k]->resolution_id);
            }
        }
        $uniqueResolutionNum = array_unique($resolutionNum);
        //배열에서 중복된 원소 없애고 해당 원소들을 resolution_id로 가지고 있는 Resolution객체 $uniqueResolutionNum에 저장하기

        $finalResolution = new Collection([]);
        for ($k = 0; $k < count($uniqueResolutionNum); $k++) {
            $new = Resolution::where('id', $uniqueResolutionNum[$k])->get();
            $finalResolution = $finalResolution->merge($new);
        }


        $worryid = $worries->id;
        return [$finalResolution, $worryid];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkMood(Request $request)
    {
        $client_id = "3nib3y8eva";
        $client_secret = "9aPZt7KFtPhAS3VivE2AmNZWjIvAMR6CbZYJvhH5";
        $url = "https://naveropenapi.apigw.ntruss.com/sentiment-analysis/v1/analyze";
        $body = array(
            'content' => $request->content,
        );
        $bodyEncoded = json_encode($body);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = "X-NCP-APIGW-API-KEY-ID: " . $client_id;
        $headers[] = "X-NCP-APIGW-API-KEY: " . $client_secret;
        $headers[] = "Content-Type:application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // SSL 이슈가 있을 경우, 아래 코드 주석 해제
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyEncoded);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "status_code:" . $status_code . " ";
        curl_close($ch);
        if ($status_code == 200) {
            // echo $response;
        } else {
            echo "Error 내용:" . $response;
        }
        return $response;
    }
}
