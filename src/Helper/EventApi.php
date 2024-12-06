<?php

namespace App\Helper;

use App\Form\Model\SearchEvent;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EventApi
{
    private $client;
    private readonly string $BASE_URL;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
        $this->BASE_URL="https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda";
    }

    public function events(
//        ?string $city,
//        ?string $date,
        SearchEvent $searchEvent,
    ): array {
//        $url = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda";
//        $url .= "&refine.location_city=" . urlencode($city);
//        $url .= "&refine.firstdate_begin=" . urlencode($date);
$url = $this->BASE_URL;
        try {
//            $response = $this->client->request('GET', $url);
//
//            $data = $response->toArray();
//
//            $events= [];
//            foreach ($data['records'] as $record) {
//                $events[] = [
//                    'title' => $record['fields']['title_fr'] ?? 'No title',
//                    'date' => $record['fields']['daterange_fr'] ?? 'No date',
//                    'location' => $record['fields']['location_name'] ?? 'No location',
//                    'description' => $record['fields']['description_fr'] ?? 'No description',
//                    'thumbnail' => $record['fields']['thumbnail'] ?? 'No image',
//                    'url' => $record['fields']['canonicalurl'] ?? '#'
//                ];
//            }
////            return $response->toArray();
//            return $events;
            if($searchEvent->getCity()) {
                $url .= "&refine.location_city=" . $searchEvent->getCity();
            }
            if($searchEvent->getDate()) {
                $url .= "&refine.firstdate_begin=" . $searchEvent->getDate()->format('Y-m-d');
            }
            $content = file_get_contents($url);

            return json_decode($content, true);
        } catch (\Exception $e) {
            return [];
        }
}
//    public function events(){
//        $events = json_decode(file_get_contents('https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda'));
//        dump($events);
//
//        return $events;
//    }
}