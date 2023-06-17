<?php

namespace App\Controller;

use App\Entity\RegionOrState;
use App\Form\RegionOrStateType;
use App\Repository\RegionOrStateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/region/or/state')]
class RegionOrStateController extends AbstractController
{
    #[Route('/', name: 'app_region_or_state_index', methods: ['GET'])]
    public function index(RegionOrStateRepository $regionOrStateRepository): Response
    {
        return $this->render('region_or_state/index.html.twig', [
            'region_or_states' => $regionOrStateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_region_or_state_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RegionOrStateRepository $regionOrStateRepository): Response
    {
        $regionOrState = new RegionOrState();
        $form = $this->createForm(RegionOrStateType::class, $regionOrState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionOrStateRepository->save($regionOrState, true);

            return $this->redirectToRoute('app_region_or_state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('region_or_state/new.html.twig', [
            'region_or_state' => $regionOrState,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_region_or_state_show', methods: ['GET'])]
    public function show(RegionOrState $regionOrState): Response
    {
        return $this->render('region_or_state/show.html.twig', [
            'region_or_state' => $regionOrState,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_region_or_state_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RegionOrState $regionOrState, RegionOrStateRepository $regionOrStateRepository): Response
    {
        $form = $this->createForm(RegionOrStateType::class, $regionOrState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionOrStateRepository->save($regionOrState, true);

            return $this->redirectToRoute('app_region_or_state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('region_or_state/edit.html.twig', [
            'region_or_state' => $regionOrState,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_region_or_state_delete', methods: ['POST'])]
    public function delete(Request $request, RegionOrState $regionOrState, RegionOrStateRepository $regionOrStateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$regionOrState->getId(), $request->request->get('_token'))) {
            $regionOrStateRepository->remove($regionOrState, true);
        }

        return $this->redirectToRoute('app_region_or_state_index', [], Response::HTTP_SEE_OTHER);
    }
}
