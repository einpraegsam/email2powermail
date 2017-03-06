<?php

call_user_func(function () {
    # Hooks for TYPO3 FE manipulation
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] =
        'EXT:email2powermail/Classes/Hooks/ContentPostProc.php:' .
        '&In2code\\Email2powermail\\Hooks\\ContentPostProc->manipulateOutput';
    
    # Use signals
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    );

    // Manipulate email before sending example
    $signalSlotDispatcher->connect(
        \In2code\Powermail\Domain\Service\ReceiverEmailService::class,
        'setReceiverEmails',
        \In2code\Email2powermail\Slots\ReceiverEmailService::class,
        'setReceiverEmails',
        false
    );

    // Manipulate name before sending example
    $signalSlotDispatcher->connect(
        \In2code\Powermail\Domain\Service\ReceiverEmailService::class,
        'getReceiverName',
        \In2code\Email2powermail\Slots\ReceiverEmailService::class,
        'getReceiverName',
        false
    );

    // Add own markers
    $signalSlotDispatcher->connect(
        \In2code\Powermail\Domain\Repository\MailRepository::class,
        'getVariablesWithMarkersFromMail',
        \In2code\Email2powermail\Slots\MarkerSlot::class,
        'getVariablesWithMarkersFromMail',
        false
    );
});
