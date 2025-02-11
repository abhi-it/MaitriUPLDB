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
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => 'ap-south-1',
                'credentials' => [
                    'key' => 'AKIAV7JDSE4JDI7UC5WL',  //env('AWS_ACCESS_KEY_ID'),
                    'secret' => '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',   //env('AWS_SECRET_ACCESS_KEY'),
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
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => 'ap-south-1',
                'credentials' => [
                    'key' => 'AKIAV7JDSE4JDI7UC5WL',  //env('AWS_ACCESS_KEY_ID'),
                    'secret' => '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',   //env('AWS_SECRET_ACCESS_KEY'),
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

    public function view_details()
    {
        $data = '';
        return view('broadcaster.broadcaster', compact('data'));
    }

    public function start_webinar(Request $request)
    {
        $stageArn = $request->stageArn;
        return view('broadcaster.host', compact('stageArn'));
    }

    //Subscribers
    public function createSubscriberToken($stageArn)
    {
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => 'ap-south-1',
                'credentials' => [
                    'key' => 'AKIAV7JDSE4JDI7UC5WL',  //env('AWS_ACCESS_KEY_ID'),
                    'secret' => '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',   //env('AWS_SECRET_ACCESS_KEY'),
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
        return view('broadcaster.subscriber', compact('stageArn'));
    }
}