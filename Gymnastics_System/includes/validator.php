<?php
// Purpose: Server-side validation helpers for registration and updates.

function validateGymnastInput(array $data): array
{
    $errors = [];

    if (trim($data['full_name'] ?? '') === '') {
        $errors[] = 'Full name is required.';
    }
    if (mb_strlen(trim($data['full_name'] ?? ''), 'UTF-8') < 3) {
        $errors[] = 'Full name should be at least 3 characters.';
    }
    if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }
    if (!preg_match('/^[A-Z0-9-]{4,12}$/i', trim($data['membership_id'] ?? ''))) {
        $errors[] = 'Membership ID must be 4-12 characters, using letters, numbers, or hyphen.';
    }
    if (!preg_match('/^\+?[0-9\-\s]{7,15}$/', trim($data['contact_no'] ?? ''))) {
        $errors[] = 'Contact number must be 7-15 digits and may include spaces or hyphen.';
    }
    if (empty($data['training_program'] ?? '')) {
        $errors[] = 'Training program is required.';
    }
    if (empty($data['enrollment_date'] ?? '')) {
        $errors[] = 'Enrollment date is required.';
    }

    return $errors;
}
?>
