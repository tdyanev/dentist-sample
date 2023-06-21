<?php

namespace App\Repository;

use App\Entity\Appointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointment>
 *
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    public function save(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function addZero(int $d): string {
        return $d < 10 ? '0' . $d : $d;
    }

    public function findByMonth(int $year, int $month): array {
        return $this->findAppointmentsWhereDateLike($year . '-'
        . $this->addZero($month) . '%');
    }

    public function findByDay(int $year, int $month, int $day): array {
        return $this->findAppointmentsWhereDateLike($year . '-'
        . $this->addZero($month) . '-' . $this->addZero($day) . '%');
    }

    private function findAppointmentsWhereDateLike(string $string): array {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Appointment p
            WHERE p.date LIKE :date

            ORDER BY p.date ASC'
        )
        ->setParameter('date', $string);
       
        return $query->getResult();
    }
}
