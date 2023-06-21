<?php

namespace App\Controller;

use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar/{year}/{month}', name: 'app_calendar')]
    public function index(int $year = 0, int $month = 0): Response
    {
        if (!$year) { $year = date('Y'); }
        if (!$month) { $month = date('n'); }

        return $this->render('calendar/index.html.twig', [
            'year' => $year,
            'month' => $month,
            // 'appointments' => [],
            'params' => json_encode([
                'year' => intval($year),
                'month' => intval($month),
                'firstDayOfWeek' => intval(date('w', strtotime(sprintf('%d-%d-1', $year, $month)))),
                'daysInMonth' => cal_days_in_month(CAL_GREGORIAN, $month, $year),
                'fetchURL' => $this->generateUrl('app_monthly', [
                    'year' => $year,
                    'month' => $month,
                ]),
                // 'singleDayURL' => $this->generateUrl('app_single_day', [
                //     'year' => $year,
                //     'month' => $month,
                //     'day' => '?',
                // ])
            ]),
        ]);
    }

    #[Route('/calendar/{year}/{month}/{day}', name: 'app_single_day')]
    public function single_day($year, $month, $day, AppointmentRepository $ar): Response {

        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('appointment/index.html.twig', [
            'appointments' => $ar->findByDay($year, $month, $day),//this->getUser()->getAppointments(),
            'year' => $year,
            'month' => $month,
            'day' => $day,
            //'month' => $month,
        ]);
    }


    #[Route('/apts/{year}/{month}', name: 'app_monthly', methods: ['GET'])]
    public function monthly(AppointmentRepository $ar, int $year, int $month) {
        $apts = [];
        $id = $this->getUser() ? $this->getUser()->getId() : 0;

        foreach ($ar->findByMonth($year, $month) as $apt) {
            $user = $apt->getUser();
            $day = $apt->getDay();

            $apts[$day][] = [
                'user' => [
                    'email' => $user->getEmail(),
                    'full_name' => $user->getFullName(),
                    'phone' => $user->getPhone(),
                ],
                'time' => $apt->getTime(),
                //'owned' => $id == $user->getId(),

            ];
        }
        return $this->json([
            'apts' => $apts,
            'dayParams' => [
                'singleDayFetchURL' => $this->generateUrl('app_single_day', [
                    'year' => $year,
                    'month' => $month,
                    'day' => '-0-',
                ]),

                // TODO read from config or DB
                'maxAptsPerDay' => 8,
            ],
            'nextMonthURL' => $this->genCalendarLink($year, $month + 1),
            'prevMonthURL' => $this->genCalendarLink($year, $month - 1),
        ]);
    }

    #[Route('/apts/{year}/{month}/{day}', name: 'app_daily', methods: ['GET'])]
    public function daily(AppointmentRepository $ar, int $year, int $month, int $day) {
        $apts = [];

        foreach ($ar->findByDay($year, $month, $day) as $apt) {
            $user = $apt->getUser();

            $apts[$apt->getTime()] = [
                'user' => [
                    'id' => $user->getId(),
                    'full_name' => $user->getFullName(),
                ],
            ];

        }

        return $this->json($apts);
    }

    private function genCalendarLink($year, $month): string {
        if ($month === 13) {
            $month = 1;
            $year++;
        } else if (!$month) {
            $month = 12;
            $year--;
        }

        return $this->generateUrl('app_calendar', [
            'year' => $year,
            'month' => $month,
        ]);

    }

}
