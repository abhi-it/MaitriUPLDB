<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API\Role;
use Aws\IvsRealTime\IvsRealTimeClient;
use Aws\Exception\AwsException;

class BroadcastController extends Controller
{
    public function dashboard(){
        return view('broadcaster.dashboard');
    }

    //Stages List
    public function listIvsStages()
    {
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
    
            $result = $client->listStages();
            return $result['stages'] ?? [];
    
        } catch (AwsException $e) {
            return ['error' => $e->getAwsErrorMessage()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    //Stages
    public function stageList()
    {
        $stages = $this->listIvsStages();
        return view('broadcaster.stages', compact('stages'));
    }

    //Add broadcaster
    public function createPublisherToken($stageArn)
    {
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $result = $client->createParticipantToken([
                'stageArn' => $stageArn,  
                'capabilities' => ['PUBLISH'],  // Permission for publishing
                'durationSeconds' => 43200,   // 12 hours
                'userId' => 'publisher_' . uniqid(),
            ]);

            return $result['participantToken'] ?? null;

        } catch (AwsException $e) {
            return ['error' => $e->getAwsErrorMessage()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function addBroadcaster(Request $request)
    {
        $stageArn = $request->stageArn; 
        if (!$stageArn) {
            return response()->json(['error' => 'Stage ARN is required'], 400);
        }

        $data = $this->createPublisherToken($stageArn);
        return view('broadcaster.broadcaster', compact('data'));
    }

    public function getPublishersList($stageArn)
    {
        try {
            $ivsClient = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $sessionResult = $ivsClient->listStageSessions([
                'stageArn' => $stageArn,
            ]);

            if (empty($sessionResult['stageSessions'])) {
                return response()->json(['error' => 'No active sessions found'], 404);
            }

            $sessionId = $sessionResult['stageSessions'][0]['sessionId']; 

            $participantResult = $ivsClient->listParticipants([
                'stageArn' => $stageArn,
                'sessionId' => $sessionId,
            ]);

            $publishers = $participantResult['participants'];

            return response()->json(['publishers' => $publishers]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function broadcasterList(Request $request)
    {
        try {
            $stageArn =  $request->stageArn;
            $response = $this->getPublishersList($stageArn);
            $originalData = $response->getData(true); 
            $allData = $originalData['publishers'];
           
            return view('broadcaster.broadcaster_list', compact('allData','stageArn'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function view_details()
    {
        $data = '';
        return view('broadcaster.broadcaster', compact('data'));
    }

    public function start_webinar(Request $request)
    {
        try {
            $stageArn = $request->stageArn;
            $data = $this->createPublisherToken($stageArn);
            $token = $data['token'];

            return view('broadcaster.host', compact('stageArn','token'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Subscribers
    public function createSubscriberToken($stageArn)
    {
        // require_once base_path('vendor/autoload.php'); 
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
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

    public function generateSubscriberToken(Request $request)
    {
        $stageArn = $request->stageArn;

        if (!$stageArn) {
            return response()->json(['error' => 'Stage ARN is required'], 400);
        }

        $data = $this->createSubscriberToken($stageArn);
        $originalData = $data->getData(true); 
      
        return view('broadcaster.viewers', compact('originalData','stageArn'));
    }

    public function join_webinar(Request $request)
    {
        $stageArn = $request->stageArn;
        if (!$stageArn) {
            return response()->json(['error' => 'Stage ARN is required'], 400);
        }

        $response = $this->createSubscriberToken($stageArn);
        $data = json_decode($response->getContent(), true);  
        $token = $data['subscriber_token']['token'] ?? null;

        return view('broadcaster.subscriber', compact('stageArn','token'));
    }

    public function ivs_latency(Request $request)
    {
        return view('broadcaster.ivs_latency');
    }
}