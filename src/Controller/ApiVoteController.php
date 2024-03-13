<?php

namespace App\Controller;

use App\Entity\Poll;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ApiVoteController extends AbstractController
{
    #[Route("/api/polls/{id}/vote/{index}", methods: 'PATCH')]
    public function vote(Poll $poll, int $index, EntityManagerInterface $entityManager): JsonResponse
    {
        $votes = $poll->getVotes();
        if ($index >= sizeof($votes)) {
            throw new BadRequestHttpException("invalid index");
        }
        $votes[$index]++;
        $poll->setVotes($votes);
        $entityManager->flush();
        return new JsonResponse(["status" => "done"]);
    }
}
