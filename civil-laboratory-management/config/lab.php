<?php

return [
    'roles' => ['owner', 'admin', 'lab_manager', 'technician', 'store_keeper', 'client'],
    'instrument_statuses' => ['available', 'assigned', 'maintenance', 'calibration_due', 'retired'],
    'sample_statuses' => ['received', 'in_testing', 'review', 'approved', 'reported'],
    'test_statuses' => ['scheduled', 'running', 'awaiting_review', 'approved', 'rejected'],
];
