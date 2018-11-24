<?php
/**
 * Created by PhpStorm.
 * User: rocket
 * Date: 2018-11-21
 * Time: 22:01
 */

namespace App\Service;


class YouTubeService
{
    public function getItemsFromChannel()
    {
        $client = $this->getClient();
        $service = new \Google_Service_YouTube($client);

        $params = [
            'maxResults' => 25,
            'playlistId' => 'PLKrKzhBjw2Y8XpxPMbaTvc8hHLqDTcDNF'
        ];

        $videoList = $this->playlistItemsListByPlaylistId($service, 'snippet',$params);
        $videos = array_reverse($videoList['items']);


        return $videos;
    }

    private function getClient() {
        $client = new \Google_Client();
        $client->setApplicationName('API Samples');
        $client->setDeveloperKey($_ENV['GOOGLE_API_KEY']);


        return $client;
    }

    private function playlistItemsListByPlaylistId($service, $part, $params) {
        $params = array_filter($params);
        $response = $service->playlistItems->listPlaylistItems(
            $part,
            $params
        );

        return $response;
    }
}