<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API\Role;
use Aws\IvsRealTime\IvsRealTimeClient;
use Aws\Exception\AwsException;
use Aws\Ivs\IvsClient;

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
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
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
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
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
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
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


    //---------------------------latency-------------------------------//
    public function ivs_latency(Request $request)
    {
        $stream_key = $request->stream_key;
        $ingest_endpoint = $request->ingest_endpoint;

        return view('broadcaster.ivs_latency', compact('stream_key','ingest_endpoint'));
    }

    public function add_channel()
    {
        return view('broadcaster.add_channel');
    }

    public function createChannel(Request $request)
    {
        require_once base_path('vendor/aws/aws-sdk-php/src/Ivs/IvsClient.php');
        try {
            $ivsClient = new IvsClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $result = $ivsClient->createChannel([
                'name'         => str_replace(' ', '_', $request->name), 
                'latencyMode'  => $request->latency_mode,
                'type'         => $request->type,
                'authorized'   => false, 
            ]);

            $playbackUrl = $result['channel']['playbackUrl'] ?? null;

            // return $data = [
            //     'channel_arn'  => $result['channel']['arn'],
            //     'stream_key'   => $result['streamKey']['value'],
            //     'playback_url' => $playbackUrl, 
            // ];

            return redirect('/ivs-channleList')->with('success','Channel Created successfully!');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listChannels()
    {
        require_once base_path('vendor/aws/aws-sdk-php/src/Ivs/IvsClient.php');
        try {
            $ivsClient = new IvsClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
    
            $result = $ivsClient->listChannels([]);
            $channels = $result['channels'];
            $data = [];
    
            foreach ($channels as $channel) {
                $channelArn = $channel['arn'];
    
                $channelDetails = $ivsClient->getChannel(['arn' => $channelArn]);
                $streamKeyResult = $ivsClient->listStreamKeys(['channelArn' => $channelArn]);
                $streamKey = !empty($streamKeyResult['streamKeys']) ? $streamKeyResult['streamKeys'][0]['arn'] : null;
    
                $data[] = [
                    'channel_arn'      => $channelArn,
                    'channel_name'     => $channel['name'],
                    'ingest_endpoint'  => $channelDetails['channel']['ingestEndpoint'] ?? null,
                    'stream_key'       => $streamKey,
                    'playback_url' => $channelDetails['channel']['playbackUrl'] ?? null,
                ];
            }
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()]; 
        }
    }   

    public function channels_list(Request $request)
    {
        require_once base_path('vendor/aws/aws-sdk-php/src/IVSRealTime/IVSRealTimeClient.php');
        try {
            $channels = $this->listChannels();
            if (isset($channels['error'])) {
                return response()->json(['error' => $channels['error']], 500);
            }
            return view('broadcaster.channel_list', compact('channels'));

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    //Playback URL

    //get
    public function playback(Request $request)
    {
        $playbackUrl = $request->query('playback_url');

        if (!$playbackUrl) {
            return redirect()->back()->with('error', 'Playback URL not found.');
        }

        return view('broadcaster.playback', compact('playbackUrl'));
    }

    //post
    public function ivsPlayback(Request $request)
    {
        $playbackUrl = $request->playback_url; 

        return view('broadcaster.playback', compact('playbackUrl'));
    }


}