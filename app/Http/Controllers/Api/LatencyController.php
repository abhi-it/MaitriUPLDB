<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aws\Ivs\IvsClient;
use Aws\IvsRealTime\IvsRealTimeClient;
use Aws\Exception\AwsException;

class LatencyController extends Controller
{
    public function streamData(Request $request)
    {
        try{
        $channelArn = 'arn:aws:ivs:us-west-2:123456789012:channel/abcd1234';
        $streamInfo = $this->getIvsStreamInfo($channelArn);

        return response()->json(['stream_details' => $streamInfo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getIvsStreamInfo($channelArn)
    {
        require_once base_path('vendor/autoload.php'); 
        try{
            $ivsClient = new IvsClient([
                'version' => 'latest',
                'region' => env('AWS_IVS_LATENCY_REGION','us-west-2'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $channels = $ivsClient->listChannels();
            // $streamKeys = $ivsClient;
            // dd($streamKeys);

            $streamKeys = $ivsClient->listStreamKeys([
                'channelArn' => $channelArn,
            ]);

            if (empty($streamKeys['streamKeys'])) {      
                // No stream keys exist, create a new one
                $newStreamKey = $ivsClient->createStreamKey([
                    'channelArn' => $channelArn,
                ]);

                $streamKey = $newStreamKey['streamKey']['value'];
            } else {
                $streamKey = $streamKeys['streamKeys'][0]['value'];
            }

            $channel = $ivsClient->getChannel([
                'arn' => $channelArn,
            ]);

            $ingestEndpoint = $channel['channel']['ingestEndpoint'];

            return [
                'ingest_endpoint' => $ingestEndpoint,
                'stream_key' => $streamKey,
            ];
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}
