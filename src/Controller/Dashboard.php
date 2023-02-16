<?php

namespace App\Controller;

use App\Repository\ChatRepository;
use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Dashboard extends AbstractController
{
    private Security $security;
    private ClientRepository $clientRepository;
    private OrderRepository $orderRepository;
    private ChatRepository $chatRepository;

    public function __construct(
        Security $security,
        ClientRepository $clientRepository,
        OrderRepository $orderRepository,
        ChatRepository $chatRepository,
    ){
        $this->security = $security;
        $this->clientRepository = $clientRepository;
        $this->orderRepository = $orderRepository;
        $this->chatRepository = $chatRepository;

    }
    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/dashboard', name: 'dashboard')]
    public function do(): Response
    {
        $totalByUsersClients = $this->clientRepository->totalByUser($this->security->getUser()->getId());
        $totalClientsByUsers = $this->clientRepository->totalUsers($this->security->getUser()->getId());
        $ordersByDates = $this->orderRepository->ordersByDate(
            $this->security->getUser()->getId(),
            date('Y-m-d H:i:s')
        );
        $ordersByDatesLast = $this->orderRepository->ordersByDate(
            $this->security->getUser()->getId(),
            date('Y-m-d H:i:s', strtotime('-7 days'))
        );
        $amountOrdersByMonths = $this->orderRepository->ordersByMonth(
            $this->security->getUser()->getId(),
            date('Y-m-d H:i:s', strtotime('-12 months')),
            date('Y-m-d H:i:s')
        );
        $amountOrdersByMonthsLast = $this->orderRepository->ordersByMonth(
            $this->security->getUser()->getId(),
            date('Y-m-d H:i:s', strtotime('-24 months')),
            date('Y-m-d H:i:s', strtotime('-12 months'))
        );
        $totalOrdersThisWeek = $this->orderRepository->totalOrdersThisWeek($this->security->getUser()->getId());
        $totalOrdersAmountThisYear = $this->orderRepository->amountThisYear($this->security->getUser()->getId());
        $chatMSGs = $this->chatRepository->showMsg();

        //  id
        //  user_id   7
        //  action_at
        // object_id 123
        // action string 'change order'
        // values text  {'sum':  {'was':  12, 'new': 33}}

//        echo "<pre>", var_dump($ordersByDates), "</pre>";
//        echo "<pre>", var_dump($ordersByDatesLast), "</pre>";
       // echo "<pre>", var_dump($totalOrdersThisWeek), "</pre>";
       // echo "<pre>", var_dump($totalOrdersAmountThisYear), "</pre>";

        $resultAmountOrdersByMonth = [];
        $resultAmountOrderByMonthLast = [];
        $resultCountOrdersByDay = [];
        $resultCountLastOrdersByDay = [];
        for ($i=11; $i >= 0; $i--) {
            $month = date('M', strtotime("-$i months"));
            foreach ($amountOrdersByMonths as $ordersByMonth) {
                if ($ordersByMonth['month'] === $month) {
                    $resultAmountOrdersByMonth[$month] = $ordersByMonth['sum'];
                }
            }
            if (!isset($resultAmountOrdersByMonth[$month])) {
                $resultAmountOrdersByMonth[$month] = 0;
            }

            foreach ($amountOrdersByMonthsLast as $orderByMonthLast) {
                if ($orderByMonthLast['month'] === $month) {
                    $resultAmountOrderByMonthLast[$month] = $orderByMonthLast['sum'];
                }
            }
            if(!isset($resultAmountOrderByMonthLast[$month])) {
                $resultAmountOrderByMonthLast[$month] = 0;
            }
        }
        for ($i=6; $i >= 0; $i--)  {
            $day = date('D',  strtotime("-$i days"));
            foreach ($ordersByDates as $ordersByDay) {
                if ($ordersByDay['day'] === $day) {
                    $resultCountOrdersByDay[$day] = $ordersByDay['count'];
                }
            }
            if (!isset($resultCountOrdersByDay[$day])) {
                $resultCountOrdersByDay[$day] = 0;
            }

            foreach ($ordersByDatesLast as $ordersByDayLast) {
                if ($ordersByDayLast['day'] === $day) {
                    $resultCountLastOrdersByDay[$day] = $ordersByDayLast['count'];
                }
            }
            if (!isset($resultCountLastOrdersByDay[$day])) {
                $resultCountLastOrdersByDay[$day] = 0;
            }
        }

//        echo "<pre>", var_dump($resultCountOrdersByDay), "</pre>";

        // вернуть для 4х показателей
        return $this->render(
            'dashboard.twig',
        [
            'totalByUsersClients' => $totalByUsersClients,
            'totalClientsByUsers' => $totalClientsByUsers,
            'totalOrdersThisWeek' => $totalOrdersThisWeek,
            'totalOrdersAmountThisYear' => $totalOrdersAmountThisYear,
            'countDaysNames' => "['" . implode("','",  array_keys($resultCountOrdersByDay)) . "']",
            'countByDaysCurrent' => "[" .  implode(',', array_values($resultCountOrdersByDay)) . "]",
            'countByDaysLast' => "[" .  implode(',', array_values($resultCountLastOrdersByDay)) . "]",
            'amountMonthNames' => "['" . implode("','",  array_keys($resultAmountOrdersByMonth)) . "']",
            'amountByMonthCurrent' => "[" .  implode(',', array_values($resultAmountOrdersByMonth)) . "]",
            'amountByMonthLast' => "[" . implode(',', array_values($resultAmountOrderByMonthLast)) . "]",
            'chatMSGs' => $chatMSGs,
        ]);
    }
}