<?php

namespace App\Interfaces;

/**
 * Interface DocumentDownloadInterface
 *
 * This interface defines the methods for downloading documents in bulk.
 */

interface BulkDownload
{
    /**
     * Download a bulk document based on the provided identifier.
     *
     * @param  int  $id The identifier of the document to be downloaded.
     * @return array An array containing the file name and other relevant details.
     */
    public function downloadBulkDocument(int $id): array;
}
