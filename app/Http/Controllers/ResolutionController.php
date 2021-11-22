<?php

namespace App\Http\Controllers;

use App\Models\Resolution;
use App\Models\ResolutionHashTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResolutionController extends Controller
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

    public function worryResolution(Request $request)
    {

        $request->validate([
            "finalHashTags" => "required|array",
        ]);

        $hashtag = $request->finalHashTags;

        $outs = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outs->writeln(gettype($hashtag));


        // for ($i = 0; $i < $length; $i++) {
        //     $ResolutionHashTag = new ResolutionHashTag();
        //     $ResolutionHashTag->resolution_id = $resolutions->id;
        //     $ResolutionHashTag->hashtag = implode('', $ResolutionHashTagsArray[$i]);
        //     $ResolutionHashTag->save();
        // }


        return '사람';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "ResolutionHashTags" => "required|array",
        ]);

        $resolutions = new Resolution();
        $resolutions->title = $request->title;
        $resolutions->content = $request->content;
        $resolutions->user_id = Auth::user()->id;
        $resolutions->save();


        $ResolutionHashTagsArray = $request->ResolutionHashTags;

        $length = count($request->ResolutionHashTags);

        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->write($request->title);


        for ($i = 0; $i < $length; $i++) {
            $ResolutionHashTag = new ResolutionHashTag();
            $ResolutionHashTag->resolution_id = $resolutions->id;
            $ResolutionHashTag->hashtag = implode('', $ResolutionHashTagsArray[$i]);
            $ResolutionHashTag->save();
        }


        return redirect()->route('writeresolution');
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
