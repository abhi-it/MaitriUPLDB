<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\IvsRealTime\IvsRealTimeClient;
use Aws\Exception\AwsException;
use Aws\Ivs\IvsClient;
use App\Models\Webinar;
use App\Models\Broadcastdetails;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class WebinarController extends Controller
{
    public function subscribers(Request $request)
    {
        return view('broadcaster.subscriber');
    }

    public function host(Request $request)
    {
        return view('broadcaster.host');
    }

    public function createIvsStage(Request $request) {
        try {
            require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
            $awsKey = config('services.aws.key');
            $awsSecret = config('services.aws.secret');
            $awsRegion = config('services.aws.region');
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => $awsRegion,
                'credentials' => [
                    'key' => $awsKey,
                    'secret' => $awsSecret ,
                ],
                
            ]);
            $stageName = $request->stage_name;
            $newStageName = str_replace(' ', '-', $stageName);

            $result = $client->createStage([
                'name' => $newStageName, 
            ]);

            $local_arn = Str::random(32);
            $webinar = Webinar::create([
                'title'         => $stageName,
                'convertTitle'  => $newStageName,
                'description'   => $request->description,
                'scheduled_at'  => $request->scheduled_at,
                'stage_arn'     => $result['stage']['arn'],
                'local_arn'     => Str::random(32),
            ]);
            return redirect('/admin/webinars')->with('success','Stage created successfully.');
          
        } catch (AwsException $e) {
            return ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateIvsStage(Request $request, $id){
        $stage = Webinar::findOrFail($id);
        $stage->title = $request->stage_name;
        $stage->description = $request->description;
        $stage->scheduled_at = $request->scheduled_at;
        $stageId = $request->stage_name;
        $scheduledTime = $request->scheduled_at;
        $stage->update();
        return redirect()->route('stage.create', $id)->with('success', 'Stage Updated Successfully');
    }

    public function uploadIvsStream(Request $request){
        $request->validate([
            'video' => 'required|file|mimes:webm,mp4|max:51200', // Max 50MB
        ]);

        $file = $request->file('video');
        $filename = 'recordings/' . time() . '.webm';

        // Upload to S3
        Storage::disk('s3')->put($filename, file_get_contents($file), 'public');

        return response()->json([
            'message' => 'Video uploaded successfully!',
            'url' => Storage::disk('s3')->url($filename)
        ]);
    }
   

}