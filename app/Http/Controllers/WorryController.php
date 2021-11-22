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

        $worries = new Worry();
        $worries->title = $request->title;
        $worries->content = $request->content;
        $worries->user_id = Auth::user()->id;
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


        //지금 finalResolution이 빈 Collection이 아니라서 안 합쳐지는(?)게 문제다.

        return $finalResolution;
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
}
