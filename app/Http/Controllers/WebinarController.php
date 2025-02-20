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

    public function join_webinar(Request $request)
    {
        // $local_arn = Request::segment(count(Request::segments()));
        // if (!$local_arn) {
        //     return response()->json(['error' => 'Stage ARN is required'], 400);
        // }

        $checkArn = $request->token ? $request->token : $local_arn;
        $local_arn  = '';
        $get_local_arn = ''; 
        $stageArn = ''; 
        if($local_arn){
            $getLocalToken = Webinar::where('local_arn', 'LIKE', $local_arn)->first();
            if($getLocalToken){
                $get_local_arn = $getLocalToken->local_arn;
                $stageArn = $getLocalToken->stage_arn;
            }
        }else{
            $stageArn = $request->token; 
        }
        
      

        $response = $this->createSubscriberToken($stageArn);
        $data = json_decode($response->getContent(), true);
        $token = $data['subscriber_token']['token'] ?? null;
        return view('broadcaster.subscriber', compact('stageArn','token', 'get_local_arn'));
    }

    public function get_recording() {
        try {
            require_once base_path('vendor/aws/aws-sdk-php/src/S3/S3Client.php');
            $awsKey = config('services.aws.key');
            $awsSecret = config('services.aws.secret');
            $awsRegion = config('services.aws.region');
            $bucket = config('services.aws.awsBucket');
            
            $s3 = new S3Client([
                'version' => 'latest',
                'region' => $awsRegion,
                'credentials' => [
                    'key' => $awsKey,
                    'secret' => $awsSecret ,
                ],
                'http' => [
                    'verify' => false,
                ],
            ]);
            
            
        } catch (AwsException $e) {
            return ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createSubscriberToken($stageArn)
    {
        // require_once base_path('vendor/autoload.php'); 
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
        try {
            $awsKey = config('services.aws.key');
            $awsSecret = config('services.aws.secret');
            $awsRegion = config('services.aws.region');

            // $client = new IvsRealTimeClient([
            //     'version' => 'latest',
            //     'region' => env('AWS_IVS_REGION', 'ap-south-1'),
            //     'credentials' => [
            //         'key' => env('AWS_ACCESS_KEY_ID'),
            //         'secret' => env('AWS_SECRET_ACCESS_KEY'),
            //     ],
              
            // ]);

            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => $awsRegion,  //env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => $awsKey, //env('AWS_ACCESS_KEY_ID'),
                    'secret' => $awsSecret ,  //env('AWS_SECRET_ACCESS_KEY'),
                ],
                'http' => [
                    'verify' => false,
                ],
            ]);


            // participant token with "SUBSCRIBE" capability
            $result = $client->createParticipantToken([
                'stageArn' => $stageArn,
                'capabilities' => ['SUBSCRIBE'],  // Permission for viewing
                'durationSeconds' => 43200,   // 12 hours
                'userId' => 'subscriber_' . uniqid(),  
            ]);

            return response()->json([
                'subscriber_token' => $result['participantToken'],
                // 'userId' => $result['userId'],
                // 'expirationTime' => $result['expirationTime'],
            ]);

        } catch (AwsException $e) {
            return response()->json(['error' => $e->getAwsErrorMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}