<?php
/**
 * File Upload Security - Webshell Detection
 * ระบบตรวจจับไฟล์อันตรายและ webshell แบบหลายชั้น
 * รองรับ PHP 7.0+
 */

// ====================================================================
// CONFIGURATION
// ====================================================================

// นามสกุลไฟล์ที่อนุญาต
define('ALLOWED_EXTENSIONS', array(
    'pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp',
    'xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx',
    'zip', 'txt', 'csv'
));

// นามสกุลไฟล์อันตราย
define('DANGEROUS_EXTENSIONS', array(
    'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps', 'pht', 'phar',
    'cgi', 'pl', 'py', 'rb', 'sh', 'bat', 'cmd', 'com', 'exe',
    'asp', 'aspx', 'jsp', 'jspx', 'war',
    'htaccess', 'htpasswd',
    'shtml', 'shtm'
));

// จำกัดขนาดไฟล์ (10MB)
define('MAX_FILE_SIZE', 10 * 1024 * 1024);

// MIME types ที่อนุญาต
define('ALLOWED_MIME_TYPES', array(
    'application/pdf',
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/bmp',
    'image/webp',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-excel',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/zip',
    'application/x-zip-compressed',
    'text/plain',
    'text/csv',
    'application/octet-stream' // fallback สำหรับบาง MIME ที่ detect ไม่ได้
));

// ====================================================================
// MAIN VALIDATION FUNCTION
// ====================================================================

/**
 * ตรวจสอบไฟล์อัปโหลดแบบหลายชั้น
 *
 * @param string $file_name    ชื่อไฟล์จาก $_FILES['name']
 * @param string $file_tmp     path ไฟล์ชั่วคราว จาก $_FILES['tmp_name']
 * @param string $file_type    MIME type จาก client (ไม่น่าเชื่อถือ)
 * @param int    $file_size    ขนาดไฟล์ bytes จาก $_FILES['size']
 * @return array ['safe' => bool, 'reason' => string]
 */
function validateFileUpload($file_name, $file_tmp, $file_type, $file_size) {
    // ชั้น 0: ตรวจขนาดไฟล์
    if ($file_size > MAX_FILE_SIZE) {
        return array(
            'safe' => false,
            'reason' => 'ไฟล์มีขนาดเกิน ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB'
        );
    }

    // ชั้น 1: ตรวจ Extension Whitelist
    $ext_check = checkExtension($file_name);
    if (!$ext_check['safe']) {
        return $ext_check;
    }

    // ชั้น 2: ตรวจ Double Extension
    $double_ext_check = checkDoubleExtension($file_name);
    if (!$double_ext_check['safe']) {
        return $double_ext_check;
    }

    // ชั้น 3: ตรวจ MIME Type จริง (ใช้ finfo)
    $mime_check = checkMimeType($file_tmp, $file_name);
    if (!$mime_check['safe']) {
        return $mime_check;
    }

    // ชั้น 4: Scan เนื้อหาไฟล์หา webshell patterns
    $content_check = scanFileContent($file_tmp, $file_name);
    if (!$content_check['safe']) {
        return $content_check;
    }

    // ชั้น 5: ถ้าเป็น ZIP ให้สแกนไฟล์ข้างใน
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if ($ext === 'zip') {
        $zip_check = scanZipArchive($file_tmp);
        if (!$zip_check['safe']) {
            return $zip_check;
        }
    }

    return array('safe' => true, 'reason' => '');
}

// ====================================================================
// LAYER 1: Extension Whitelist
// ====================================================================

/**
 * ตรวจนามสกุลไฟล์ว่าอยู่ใน whitelist หรือไม่
 */
function checkExtension($file_name) {
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (empty($ext)) {
        return array(
            'safe' => false,
            'reason' => 'ไฟล์ไม่มีนามสกุล ไม่อนุญาตให้อัปโหลด'
        );
    }

    if (!in_array($ext, ALLOWED_EXTENSIONS, true)) {
        return array(
            'safe' => false,
            'reason' => 'นามสกุลไฟล์ .' . $ext . ' ไม่ได้รับอนุญาต อนุญาตเฉพาะ: ' . implode(', ', ALLOWED_EXTENSIONS)
        );
    }

    return array('safe' => true, 'reason' => '');
}

// ====================================================================
// LAYER 2: Double Extension Detection
// ====================================================================

/**
 * ตรวจจับ double extension เช่น test.php.pdf, shell.phtml.jpg
 */
function checkDoubleExtension($file_name) {
    // ลบนามสกุลสุดท้ายออก แล้วดูว่ามีนามสกุลอันตรายซ่อนอยู่ไหม
    $name_without_last_ext = pathinfo($file_name, PATHINFO_FILENAME);
    $parts = explode('.', $name_without_last_ext);

    foreach ($parts as $part) {
        $part_lower = strtolower(trim($part));
        if (in_array($part_lower, DANGEROUS_EXTENSIONS, true)) {
            return array(
                'safe' => false,
                'reason' => 'ตรวจพบนามสกุลไฟล์อันตราย ".' . $part_lower . '" ซ่อนอยู่ในชื่อไฟล์ "' . $file_name . '"'
            );
        }
    }

    // ตรวจ null byte injection (อาจใช้ bypass ใน PHP เวอร์ชันเก่า)
    if (strpos($file_name, "\0") !== false || strpos($file_name, '%00') !== false) {
        return array(
            'safe' => false,
            'reason' => 'ตรวจพบ null byte ในชื่อไฟล์ — อาจเป็นการโจมตี'
        );
    }

    return array('safe' => true, 'reason' => '');
}

// ====================================================================
// LAYER 3: MIME Type Validation
// ====================================================================

/**
 * ตรวจ MIME type จริงของไฟล์โดยใช้ finfo (ไม่เชื่อ client)
 */
function checkMimeType($file_tmp, $file_name) {
    if (!function_exists('finfo_open')) {
        // ถ้าไม่มี finfo ให้ข้ามขั้นตอนนี้ (ไม่บล็อก แต่ log ไว้)
        error_log('[SECURITY WARNING] finfo extension not available, MIME check skipped for: ' . $file_name);
        return array('safe' => true, 'reason' => '');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $real_mime = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    if ($real_mime === false) {
        return array(
            'safe' => false,
            'reason' => 'ไม่สามารถตรวจสอบประเภทไฟล์ได้'
        );
    }

    // ตรวจว่า MIME type เป็น PHP/script หรือไม่
    $dangerous_mimes = array(
        'application/x-php',
        'application/x-httpd-php',
        'application/x-httpd-php-source',
        'text/x-php',
        'application/x-perl',
        'application/x-python',
        'application/x-ruby',
        'application/x-shellscript',
        'application/x-sh',
        'application/x-csh',
        'application/x-executable',
        'application/x-msdos-program'
    );

    if (in_array($real_mime, $dangerous_mimes, true)) {
        return array(
            'safe' => false,
            'reason' => 'ตรวจพบไฟล์ประเภทอันตราย (MIME: ' . $real_mime . ')'
        );
    }

    // ตรวจสอบว่า MIME type ตรงกับนามสกุลไฟล์หรือไม่
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $ext_mime_map = array(
        'pdf'  => array('application/pdf'),
        'jpg'  => array('image/jpeg'),
        'jpeg' => array('image/jpeg'),
        'png'  => array('image/png'),
        'gif'  => array('image/gif'),
        'bmp'  => array('image/bmp', 'image/x-ms-bmp'),
        'webp' => array('image/webp'),
        'xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/octet-stream'),
        'xls'  => array('application/vnd.ms-excel', 'application/octet-stream'),
        'doc'  => array('application/msword', 'application/octet-stream'),
        'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/octet-stream'),
        'ppt'  => array('application/vnd.ms-powerpoint', 'application/octet-stream'),
        'pptx' => array('application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip', 'application/octet-stream'),
        'zip'  => array('application/zip', 'application/x-zip-compressed', 'application/octet-stream'),
        'txt'  => array('text/plain'),
        'csv'  => array('text/plain', 'text/csv', 'application/csv', 'application/octet-stream')
    );

    if (isset($ext_mime_map[$ext])) {
        if (!in_array($real_mime, $ext_mime_map[$ext], true)) {
            // สำหรับ binary formats (office docs) ที่ finfo อาจ detect ไม่ตรง → ผ่อนปรน
            $binary_exts = array('xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx');
            if (in_array($ext, $binary_exts, true) && $real_mime === 'application/octet-stream') {
                return array('safe' => true, 'reason' => '');
            }

            return array(
                'safe' => false,
                'reason' => 'ประเภทไฟล์ไม่ตรงกับนามสกุล (นามสกุล: .' . $ext . ', MIME จริง: ' . $real_mime . ')'
            );
        }
    }

    return array('safe' => true, 'reason' => '');
}

// ====================================================================
// LAYER 4: Content Scanning
// ====================================================================

/**
 * สแกนเนื้อหาไฟล์หา PHP tags และ webshell patterns
 */
function scanFileContent($file_tmp, $file_name) {
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // ข้ามการ scan binary formats ที่อาจเกิด false positive
    $binary_formats = array('xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'pdf');
    if (in_array($ext, $binary_formats, true)) {
        // สำหรับ binary format → scan เฉพาะ PHP opening tag ที่ต้นไฟล์
        return scanBinaryFileHeader($file_tmp, $file_name);
    }

    // สำหรับไฟล์ text/image → scan เต็ม
    $content = file_get_contents($file_tmp);
    if ($content === false) {
        return array(
            'safe' => false,
            'reason' => 'ไม่สามารถอ่านเนื้อหาไฟล์ได้'
        );
    }

    // Patterns ที่บ่งบอกว่าเป็น webshell
    $webshell_patterns = array(
        // PHP tags
        '/<\?php/i'                              => 'PHP opening tag',
        '/<\?=/i'                                => 'PHP short echo tag',
        '/<\?\s/i'                               => 'PHP short open tag',

        // Dangerous functions
        '/\b(eval)\s*\(/i'                       => 'eval() function',
        '/\b(exec)\s*\(/i'                       => 'exec() function',
        '/\b(system)\s*\(/i'                     => 'system() function',
        '/\b(shell_exec)\s*\(/i'                 => 'shell_exec() function',
        '/\b(passthru)\s*\(/i'                   => 'passthru() function',
        '/\b(proc_open)\s*\(/i'                  => 'proc_open() function',
        '/\b(popen)\s*\(/i'                      => 'popen() function',

        // Obfuscation techniques
        '/\b(base64_decode)\s*\(/i'              => 'base64_decode() — อาจใช้ซ่อน code',
        '/\b(gzinflate)\s*\(/i'                  => 'gzinflate() — อาจใช้ซ่อน code',
        '/\b(str_rot13)\s*\(/i'                  => 'str_rot13() — อาจใช้ซ่อน code',
        '/\b(assert)\s*\(/i'                     => 'assert() — อาจใช้ execute code',
        '/\b(preg_replace)\s*\(.*\/e/i'          => 'preg_replace with /e modifier',
        '/\b(create_function)\s*\(/i'            => 'create_function() — dynamic code',

        // Hex-encoded PHP tags
        '/\\\\x3c\\\\x3fphp/i'                  => 'Hex-encoded PHP tag',
        '/\\\\x3c\\\\x3f/i'                     => 'Hex-encoded short tag',

        // Common webshell signatures
        '/\b(c99shell|r57shell|wso|b374k)/i'     => 'Known webshell signature',
        '/\$_(GET|POST|REQUEST)\s*\[/i'          => 'PHP superglobal access',
    );

    foreach ($webshell_patterns as $pattern => $description) {
        if (preg_match($pattern, $content)) {
            return array(
                'safe' => false,
                'reason' => 'ตรวจพบเนื้อหาอันตรายในไฟล์: ' . $description . ' (ไฟล์: ' . $file_name . ')'
            );
        }
    }

    return array('safe' => true, 'reason' => '');
}

/**
 * สแกน header ของ binary file ว่ามี PHP tag ซ่อนอยู่หรือไม่
 */
function scanBinaryFileHeader($file_tmp, $file_name) {
    // อ่าน 256 bytes แรกเพื่อตรวจว่าไฟล์เริ่มต้นด้วย PHP tag หรือไม่
    $handle = fopen($file_tmp, 'rb');
    if (!$handle) {
        return array(
            'safe' => false,
            'reason' => 'ไม่สามารถเปิดไฟล์เพื่อตรวจสอบได้'
        );
    }

    $header = fread($handle, 256);
    fclose($handle);

    // ตรวจว่า binary file เริ่มต้นด้วย PHP tag
    $php_patterns = array(
        '/<\?php/i',
        '/<\?=/i',
        '/<\?\s/',
    );

    foreach ($php_patterns as $pattern) {
        if (preg_match($pattern, $header)) {
            return array(
                'safe' => false,
                'reason' => 'ตรวจพบ PHP code ซ่อนอยู่ใน header ของไฟล์ "' . $file_name . '"'
            );
        }
    }

    return array('safe' => true, 'reason' => '');
}

// ====================================================================
// LAYER 5: ZIP Archive Scanning
// ====================================================================

/**
 * สแกนทุกไฟล์ภายใน ZIP archive
 */
function scanZipArchive($file_tmp) {
    if (!class_exists('ZipArchive')) {
        error_log('[SECURITY WARNING] ZipArchive not available, ZIP scan skipped');
        return array('safe' => true, 'reason' => '');
    }

    $zip = new ZipArchive();
    $result = $zip->open($file_tmp);

    if ($result !== true) {
        return array(
            'safe' => false,
            'reason' => 'ไม่สามารถเปิดไฟล์ ZIP ได้ อาจเป็นไฟล์ที่เสียหายหรือไม่ใช่ ZIP จริง'
        );
    }

    for ($i = 0; $i < $zip->numFiles; $i++) {
        $entry_name = $zip->getNameIndex($i);

        // ตรวจ directory traversal
        if (strpos($entry_name, '..') !== false || strpos($entry_name, '/..') !== false) {
            $zip->close();
            return array(
                'safe' => false,
                'reason' => 'ตรวจพบ directory traversal ใน ZIP: ' . $entry_name
            );
        }

        // ตรวจ dangerous extension ข้างใน ZIP
        $entry_ext = strtolower(pathinfo($entry_name, PATHINFO_EXTENSION));
        if (in_array($entry_ext, DANGEROUS_EXTENSIONS, true)) {
            $zip->close();
            return array(
                'safe' => false,
                'reason' => 'ตรวจพบไฟล์อันตราย "' . $entry_name . '" ภายใน ZIP (นามสกุล: .' . $entry_ext . ')'
            );
        }

        // ตรวจ double extension ข้างใน ZIP
        $double_check = checkDoubleExtension($entry_name);
        if (!$double_check['safe']) {
            $zip->close();
            return array(
                'safe' => false,
                'reason' => 'ตรวจพบไฟล์อันตรายใน ZIP: ' . $double_check['reason']
            );
        }

        // สแกน content ของไฟล์ text-based ข้างใน ZIP
        $text_exts = array('txt', 'csv', 'html', 'htm', 'xml', 'json', 'js', 'css');
        if (in_array($entry_ext, $text_exts, true)) {
            $entry_content = $zip->getFromIndex($i);
            if ($entry_content !== false) {
                // ตรวจ PHP tags ในไฟล์ text
                $php_patterns = array(
                    '/<\?php/i',
                    '/<\?=/i',
                );
                foreach ($php_patterns as $pattern) {
                    if (preg_match($pattern, $entry_content)) {
                        $zip->close();
                        return array(
                            'safe' => false,
                            'reason' => 'ตรวจพบ PHP code ซ่อนอยู่ในไฟล์ "' . $entry_name . '" ภายใน ZIP'
                        );
                    }
                }
            }
        }
    }

    $zip->close();
    return array('safe' => true, 'reason' => '');
}

// ====================================================================
// UTILITY FUNCTIONS
// ====================================================================

/**
 * ทำให้ชื่อไฟล์ปลอดภัย — ลบ path traversal และสร้าง unique name
 *
 * @param string $file_name    ชื่อไฟล์ต้นฉบับ
 * @return string ชื่อไฟล์ที่ปลอดภัย
 */
function sanitizeFileName($file_name) {
    // ลบ path components
    $file_name = basename($file_name);

    // ลบอักขระพิเศษ เก็บเฉพาะ alphanumeric, dash, underscore, dot, ภาษาไทย
    $file_name = preg_replace('/[^\p{L}\p{N}\.\-\_]/u', '_', $file_name);

    // เพิ่ม unique prefix ป้องกันชื่อซ้ำ
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $name = pathinfo($file_name, PATHINFO_FILENAME);
    $unique = date('Ymd_His') . '_' . substr(md5(uniqid(mt_rand(), true)), 0, 8);

    return $name . '_' . $unique . '.' . $ext;
}

/**
 * Log security event
 */
function logSecurityEvent($event_type, $file_name, $reason, $user_code = '') {
    $log_entry = sprintf(
        "[%s] SECURITY_%s | User: %s | File: %s | Reason: %s",
        date('Y-m-d H:i:s'),
        strtoupper($event_type),
        $user_code,
        $file_name,
        $reason
    );

    error_log($log_entry);
}

?>
