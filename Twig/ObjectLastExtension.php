<?php

namespace Pix\SortableBehaviorBundle\Twig;

use Pix\SortableBehaviorBundle\Services\PositionHandler;

/**
 * Description of ObjectLastExtension
 *
 * @author Volker von Hoesslin <volker.von.hoesslin@empora.com>
 */
class ObjectLastExtension extends \Twig_Extension
{
    const NAME = 'sortableObjectLast';

    /** @var PositionHandler $position_service */
    private $position_service;

    function __construct(PositionHandler $position_service)
    {
        $this->position_service = $position_service;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return self::NAME;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(self::NAME,
                function ($entity)
                {
                    return $this->position_service->getLastPosition($entity);
                }
            )
        );
    }
}
