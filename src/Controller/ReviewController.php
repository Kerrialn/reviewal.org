<?php

namespace App\Controller;

use App\DataTransferObject\AddressFilterDto;
use App\Entity\Review;
use App\Entity\User;
use App\Form\Filter\AddressFilterType;
use App\Form\Form\ReviewFormType;
use App\Repository\AddressRepository;
use App\Repository\ReviewRepository;
use App\Service\GeneralRatingCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/reviews')]
class ReviewController extends AbstractController
{

    public function __construct(
        private readonly ReviewRepository               $reviewRepository,
        private readonly AddressRepository              $addressRepository,
        private readonly GeneralRatingCalculatorService $generalRatingCalculatorService,
        private readonly TranslatorInterface $translator
    )
    {
    }

    #[Route('/', name: 'landing_index')]
    public function index(Request $request): Response
    {
        $addressFilterDto = new AddressFilterDto();
        $addressFilterForm = $this->createForm(AddressFilterType::class, $addressFilterDto);
        $addresses = $this->addressRepository->findByFilter($addressFilterForm->getData());

        $addressFilterForm->handleRequest($request);
        if ($addressFilterForm->isSubmitted() && $addressFilterForm->isValid()) {
            $addresses = $this->addressRepository->findByFilter($addressFilterForm->getData());

            return $this->render('review/index.html.twig', [
                'addresses' => $addresses,
                'addressFilterForm' => $addressFilterForm->createView()
            ]);
        }

        return $this->render('review/index.html.twig', [
            'addresses' => $addresses,
            'addressFilterForm' => $addressFilterForm->createView()
        ]);
    }


    #[Route('/create', name: 'review_new')]
    public function create(Request $request): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $review = new Review();
        $address = $request->get('address');
        if($address){
            $address = $this->addressRepository->find($address);
            $review->setAddress($address);
        }

        $review->setOwner($currentUser);
        $reviewForm = $this->createForm(ReviewFormType::class, $review);

        $reviewForm->handleRequest($request);
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {

            $hasReviewed = $this->reviewRepository->findOneBy([
                'address' => $reviewForm->get('address')->getData(),
                'owner' => $currentUser
            ]);
            if($hasReviewed instanceof Review){
                $this->addFlash('warning', $this->translator->trans('already-reviewed-address'));
                return $this->redirectToRoute('address_show', ['id' => $hasReviewed->getAddress()->getId()]);
            }

            $buildingRating = $reviewForm->get('buildingRating')->getData();
            $priceRating = $reviewForm->get('priceRating')->getData();
            $managementRating = $reviewForm->get('managementRating')->getData();
            $locationRating = $reviewForm->get('locationRating')->getData();
            $transportRating = $reviewForm->get('transportRating')->getData();

            $generalRating = $this->generalRatingCalculatorService->calculate(
                buildingRating: $buildingRating,
                priceRating: $priceRating,
                managementRating: $managementRating,
                locationRating: $locationRating,
                transportRating: $transportRating,
            );

            $review->setGeneralRating($generalRating);
            $review->setBuildingRating((string)round($buildingRating, 1));
            $review->setPriceRating((string)round($priceRating, 1));
            $review->setManagementRating((string)round($managementRating, 1));
            $review->setLocationRating((string)round($locationRating, 1));
            $review->setTransportRating((string)round($transportRating, 1));
            $this->reviewRepository->save($review, true);
            return $this->redirectToRoute('address_show', ['id' => $review->getAddress()->getId()]);
        }

        return $this->render('review/new.html.twig', [
            'reviewForm' => $reviewForm->createView()
        ]);
    }


    #[Route('/edit/{id}', name: 'edit_review')]
    public function edit(Review $review, Request $request): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        if ($review->getOwner() !== $currentUser) {
            return $this->redirectToRoute('user_dashboard');
        }

        $reviewForm = $this->createForm(ReviewFormType::class, $review);

        $reviewForm->handleRequest($request);
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {

            $hasReviewed = $this->reviewRepository->findOneBy([
                'address' => $reviewForm->get('address')->getData(),
                'owner' => $currentUser
            ]);

            if($hasReviewed instanceof Review && $hasReviewed !== $review){
                $this->addFlash('message', $this->translator->trans('already-reviewed-address'));
                return $this->redirectToRoute('edit_review', ['id' => $review->getId()]);
            }

            $buildingRating = $reviewForm->get('buildingRating')->getData();
            $priceRating = $reviewForm->get('priceRating')->getData();
            $managementRating = $reviewForm->get('managementRating')->getData();
            $locationRating = $reviewForm->get('locationRating')->getData();
            $transportRating = $reviewForm->get('transportRating')->getData();

            $generalRating = $this->generalRatingCalculatorService->calculate(
                buildingRating: $buildingRating,
                priceRating: $priceRating,
                managementRating: $managementRating,
                locationRating: $locationRating,
                transportRating: $transportRating,
            );

            $review->setGeneralRating($generalRating);
            $review->setBuildingRating((string)round($buildingRating, 1));
            $review->setPriceRating((string)round($priceRating, 1));
            $review->setManagementRating((string)round($managementRating, 1));
            $review->setLocationRating((string)round($locationRating, 1));
            $review->setTransportRating((string)round($transportRating, 1));
            $this->reviewRepository->save($review, true);

            $this->addFlash('message', $this->translator->trans('changes-saved'));
            return $this->redirectToRoute('address_show', ['id' => $review->getAddress()->getId()]);
        }

        return $this->render('review/edit.html.twig', [
            'reviewForm' => $reviewForm->createView()
        ]);
    }


    #[Route(path: '/delete/{id}', name: 'review_delete', methods: ['DELETE'])]
    public function delete(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('delete' . $review->getId(), (string)$request->request->get('_token'))) {
            $this->reviewRepository->remove($review, true);
        }

        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        if ($review->getOwner() !== $currentUser) {
            return $this->redirectToRoute('user_dashboard');
        }

        return $this->redirectToRoute('user_dashboard', [], Response::HTTP_SEE_OTHER);
    }


}
