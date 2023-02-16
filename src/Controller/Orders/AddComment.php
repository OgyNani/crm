<?php

namespace App\Controller\Orders;

use App\Entity\OrderComments;
use App\Repository\OrderCommentsRepository;
use App\Repository\OrderRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddComment extends AbstractController
{
    private OrderRepository $orderRepository;
    private OrderCommentsRepository $orderCommentsRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderCommentsRepository $orderCommentsRepository,

    ){
        $this->orderCommentsRepository = $orderCommentsRepository;
        $this->orderRepository = $orderRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/{id}/add-order-comment', name: 'client-order-comment-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $comment = new OrderComments(
            $request->request->get('orderId'),
            $request->request->get('userId'),
            $request->request->get('text'),
        );

        $this->orderCommentsRepository->save($comment);

        return $this->redirect("/client/{$comment->getOrderId()}/order-comments");
    }
}