<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aws\IvsRealTime\IvsRealTimeClient;
use Aws\Exception\AwsException;
use DB;

class IVSBroadCastController extends Controller
{
    // private function keys_validator()
    // {
    //     try {
    //         $client = new IvsRealTimeClient([
    //             'version' => 'latest',
    //             'region' => 'ap-south-1',
    //             'credentials' => [
    //                 'key' => 'AKIAV7JDSE4JDI7UC5WL',  //env('AWS_ACCESS_KEY_ID'),
    //                 'secret' => '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',   //env('AWS_SECRET_ACCESS_KEY'),
    //             ],
    //         ]);
    //     }catch (\Exception $e) {
    //         return ['error' => $e->getMessage()];
    //     }
    // }

    public function listIvsStages()
    {
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
    public function showStages()
    {
        $stages = $this->listIvsStages();
        return response()->json($stages);
    }

    //Participants/subscribers
    function getStageParticipantCount($stage)
    {
        try {
            $client = new IvsRealTimeClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Fetch stage details
            $result = $client->getStage([
                'arn' => $stage,
            ]);

            // Return participant count
            return $result['stage']['participantCount'] ?? 0;

        } catch (AwsException $e) {
            return ['error' => $e->getAwsErrorMessage()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function showParticipantCount(Request $request)
    {
        $stage = $request->stage;
        $participantCount = $this->getStageParticipantCount($stage);
        return response()->json(['participants' => $participantCount]);
    }

   
    //Create Publisher/BroadCaster
    public function createPublisherToken($stageArn)
    {
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

    public function generatePublisherToken(Request $request)
    {
        $stageArn = $request->stage; 
        if (!$stageArn) {
            return response()->json(['error' => 'Stage ARN is required'], 400);
        }

        $token = $this->createPublisherToken($stageArn);
        return response()->json(['publisher_token' => $token]);
    }

    //Create Subscribers
    public function createSubscriberToken($stageArn)
    {
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

            return response()->json(['subscriber_token' => $result['participantToken']]);

        } catch (AwsException $e) {
            return response()->json(['error' => $e->getAwsErrorMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateSubscriberToken(Request $request)
    {
        $stageArn = $request->stage;
        $token = $this->createSubscriberToken($stageArn);
        return response()->json(['subscriber_token' => $token]);
    }



}
