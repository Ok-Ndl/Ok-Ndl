<?php
// Purpose: Lightweight logging helper for delete actions.

function appendDeleteLog(string $name, string $membershipId, string $deletedBy): void
{
    $logFile = __DIR__ . '/../database/logs/deleted_records.log';
    $entry = sprintf(
        "[%s] Name=%s | MembershipID=%s | DeletedBy=%s\n",
        date('Y-m-d H:i:s'),
        $name,
        $membershipId,
        $deletedBy
    );

    $handle = fopen($logFile, 'a');
    if ($handle) {
        fwrite($handle, $entry);
        fclose($handle);
    }
}
?>
