<?php

call_user_func(function () {

    #####################################
    ## Hook for HTML manipulation #######
    #####################################
    
    # Hooks for TYPO3 FE manipulation
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] =
        'EXT:email2powermail/Classes/Hooks/ContentPostProc.php:' .
        '&In2code\\Email2powermail\\Domain\\Model\\ContentPostProc->manipulateOutput';
});
