<?php

namespace App\Http\Controllers\API;

use App\RequirementMessage;
use App\Requirement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequirementCommentAddedNotification;

class RequirementMessageController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'requirement' => 'required'
        ]);

        RequirementMessage::create([
            'message' => $request->comment,
            'user_id' => $request->user()->id,
            'requirement_id' => $request->requirement
        ]);

        $requirement = Requirement::find($request->requirement);

        // dd( $requirement->user);

        Notification::send($requirement->user, new RequirementCommentAddedNotification($requirement));

        return response()->json(['success' => true, 'message' => 'Comment successfully submitted.', 'a' => $requirement->user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequirementMessage  $requirementMessage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $requirementId = $request->requirement;

        $comments = RequirementMessage::where('requirement_id', $requirementId)->latest()->get();

        return response()->json(['success' => true, 'data' => $comments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequirementMessage  $requirementMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequirementMessage $requirementMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequirementMessage  $requirementMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequirementMessage $requirementMessage)
    {
        //
    }
}
