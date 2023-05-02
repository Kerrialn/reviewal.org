<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\Filter\AddressFilterType;
use App\Form\Form\AddressFormType;
use App\Repository\AddressRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/addresses')]
class AddressController extends AbstractController
{

    public function __construct(
        private readonly AddressRepository $addressRepository,
        private readonly ReviewRepository $reviewRepository,
    )
    {
    }

    #[Route('/{id}/show', name: 'address_show')]
    public function show(Address $address): Response
    {
        $averages = $this->reviewRepository->getAveragesByAddress($address);
        return $this->render('address/show.html.twig', [
            'averages' => $averages,
            'address' => $address
        ]);
    }

    #[Route('/new', name: 'address_new')]
    public function create(Request $request): Response
    {
        $address = new Address();
        $addressForm = $this->createForm(AddressFormType::class, $address);

        $addressForm->handleRequest($request);
        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $this->addressRepository->save($address, true);
            return $this->redirectToRoute('address_new');
        }

        return $this->render('address/new.html.twig', [
            'addressForm' => $addressForm->createView()
        ]);
    }


}
