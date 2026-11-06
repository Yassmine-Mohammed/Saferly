<?php
function app_base_url(): string
{
    static $baseUrl = null;

    if ($baseUrl !== null) {
        return $baseUrl;
    }

    $projectRoot = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');

    if ($projectRoot === false || $documentRoot === false) {
        $baseUrl = '';
        return $baseUrl;
    }

    $projectRoot = rtrim(str_replace('\\', '/', $projectRoot), '/');
    $documentRoot = rtrim(str_replace('\\', '/', $documentRoot), '/');
    $comparisonRoot = PHP_OS_FAMILY === 'Windows' ? strtolower($projectRoot) : $projectRoot;
    $comparisonDocumentRoot = PHP_OS_FAMILY === 'Windows' ? strtolower($documentRoot) : $documentRoot;

    if (
        $comparisonRoot !== $comparisonDocumentRoot
        && !str_starts_with($comparisonRoot, $comparisonDocumentRoot . '/')
    ) {
        $baseUrl = '';
        return $baseUrl;
    }

    $relativePath = ltrim(substr($projectRoot, strlen($documentRoot)), '/');
    $segments = $relativePath === '' ? [] : explode('/', $relativePath);
    $baseUrl = count($segments) === 0
        ? ''
        : '/' . implode('/', array_map('rawurlencode', $segments));

    return $baseUrl;
}

function app_url(string $path = ''): string
{
    $path = ltrim($path, '/');

    return app_base_url() . ($path === '' ? '/' : '/' . $path);
}