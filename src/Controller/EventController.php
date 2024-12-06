<?php

namespace App\Controller;

use App\Form\Model\SearchEvent;
use App\Form\SearchEventType;
use App\Helper\EventApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{

    #[Route('/events-list', name: 'events')]
    public function eventsList(Request $request, EventApi $eventApi): Response
    {

        $searchEvent = new SearchEvent();
        $searchEventFrom = $this->createForm(SearchEventType::class, $searchEvent);

        $searchEventFrom->handleRequest($request);
//        $events = $eventApi->events('Tarbes', '2024-09-21');
//        $events->
//        dd($events);
//        $city = $request->get('city');
//        $date = $request->get('date');
//
//        $events= [];
//        if ($city && $date) {
//            $response = $this->client->request(
//                'GET',
//                'events?city='.$city.'&date='.$date
//            );
//        }


//        $searchEvent->setCity('Rennes');
//        $searchEvent->setDate(new \DateTime('now'));
        $events = $eventApi->events($searchEvent);

//        $events = $eventApi->events('Tarbes', '2024-09-21');
//        dd($events);

        return $this->render('events/events-list.html.twig', [
            'events' => $events['records'],
            'searchEventForm' => $searchEventFrom,
    ]);
    }
}
