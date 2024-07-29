<?php
namespace App\Http\Traits;
use MacsiDigital\Zoom\Facades\Zoom;
trait MeetingZoomTrait
{
    public function createMeeting($request){
        $user = Zoom::user()->first();
        $meetingData = [
            'topic' => $request->topic,
            'duration' => $request->duration,
            'password' => $request->password,
            'timezone' => 'Asia/Kabul'
        ];

        $meeting = Zoom::meeting()->make($meetingData);

        $meeting->settings()->make([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'audio_recording' => config('zoom.audio_recording'),
          ]);

          return $user->meetings()->save($meeting);
    }
}
