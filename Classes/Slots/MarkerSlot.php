<?php
namespace In2code\Email2powermail\Slots;

use In2code\Email2powermail\Domain\Repository\EmailRepository;
use In2code\Email2powermail\Utility\ArrayUtility;
use In2code\Email2powermail\Utility\ConfigurationUtility;
use In2code\Email2powermail\Utility\FrontendUtility;
use In2code\Email2powermail\Utility\ObjectUtility;

/**
 * Class MarkerSlot
 */
class MarkerSlot
{

    /**
     * Add own markers
     *
     * @return void
     */
    public function getVariablesWithMarkersFromMail(&$variables)
    {
        if (ConfigurationUtility::isExtensionTurnedOn()) {
            $emailRepository = ObjectUtility::getObjectManager()->get(EmailRepository::class);
            $email = $emailRepository->findByIdentifier(FrontendUtility::getIdentifier());
            $variables = $variables + ArrayUtility::prefixArrayKeys($email->toArray());
        }
    }
}
