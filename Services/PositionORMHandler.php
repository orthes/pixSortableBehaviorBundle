<?php
/*
 * This file is part of the pixSortableBehaviorBundle.
 *
 * (c) Nicolas Ricci <nicolas.ricci@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pix\SortableBehaviorBundle\Services;

use Doctrine\ORM\EntityManagerInterface;

class PositionORMHandler extends PositionHandler
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getLastPosition($entity)
    {
        if ($group = $this->getGroupFieldByEntity($entity)) {
            $className = get_class($entity);
            $getter = sprintf('get%s', ucfirst($this->getGroupFieldByEntity($entity)));

            $query = $this->em->createQuery(sprintf(
                'SELECT MAX(m.%s) FROM %s m WHERE m.%s = %s',
                $positionFiles = $this->getPositionFieldByEntity($className),
                $className,
                $group,
                $entity->{$getter}()->getId()
            ));
        } else {
            $className = is_object($entity) ? get_class($entity) : $entity;
            $query = $this->em->createQuery(sprintf(
                'SELECT MAX(m.%s) FROM %s m',
                $positionFiles = $this->getPositionFieldByEntity($className),
                $className
            ));
        }
        $result = $query->getResult();

        if (array_key_exists(0, $result)) {
            return intval($result[0][1]);
        }

        return 0;
    }


}
