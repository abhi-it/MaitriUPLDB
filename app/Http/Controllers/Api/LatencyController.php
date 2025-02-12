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
        $channelArn = 'arn:aws:ivs:ap-south-1:410780837650:channel/cbTFnQij9NPj';
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
                // 'region' => env('AWS_IVS_LATENCY_REGION','us-west-2'),
                'region' => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // $channels = $ivsClient->listChannels();
            // $streamKeys = $ivsClient;
            // dd($streamKeys);

            $streamKeys = $ivsClient->listStreamKeys([
                'channelArn' => $channelArn,
            ]);
            dd($streamKeys);
// 
            if (empty($streamKeys['streamKeys'])) {      
                // No stream keys exist, create a new one
                $newStreamKey = $ivsClient->createChannel([
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

    public function createChannel()
    {
        try {
            $ivsClient = new IvsClient([
                'version'     => 'latest',
                'region'      => env('AWS_IVS_REGION', 'ap-south-1'),
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Create Channel
            $result = $ivsClient->createChannel([
                'name'      => 'MyNewChannel',
                'latencyMode' => 'LOW',
                'type'      => 'STANDARD',
                'authorized' => false, 
            ]);

            $channelArn = $result['channel']['arn'];
            $streamKey  = $result['streamKey']['value'];
            $ingestEndpoint = $result['channel']['ingestEndpoint'];

            return response()->json([
                'channel_arn' => $channelArn,
                'stream_key'  => $streamKey,
                'ingest_endpoint' => $ingestEndpoint,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    
}
