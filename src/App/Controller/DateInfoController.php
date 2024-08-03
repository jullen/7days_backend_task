<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\DateInfoType;
use App\DTO\DateInfoFormData;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DateInfoService;
use DateTime;

/**
 * @Route("/date-info")
 */
class DateInfoController extends AbstractController
{
    private $dateInfoService;

    public function __construct(DateInfoService $dateInfoService)
    {
        $this->dateInfoService = $dateInfoService;
    }

    /**
     * @Route("/", name="app_date_info_form")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(DateInfoType::class, new DateInfoFormData());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('app_date_info_success', [
                'date' => $data->getDate(),
                'timezone' => $data->getTimezone(),
            ]);
        }

        return $this->render('dateInfo/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/success", name="app_date_info_success")
     */
    public function success(Request $request): Response
    {
        $date = $request->get('date');
        $timezone = $request->get('timezone');

        $dateTime = new DateTime($date);

        return $this->render('dateInfo/success.html.twig', [
            'timezone' => $timezone,
            'offset' => $this->dateInfoService->getTimeOffset($timezone),
            'daysInFebruary' => $this->dateInfoService->getDaysInFebruary($dateTime->format('Y')),
            'month' => $dateTime->format('F'),
            'daysInMonth' => $dateTime->format('t'),
        ]);
    }
}
