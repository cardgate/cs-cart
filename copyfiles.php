<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

function zipfiles($filename, $rootPath){

// Initialize archive object
$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
}

function recurse_copy( $src, $dst, $is_dir ) {
    if ( $is_dir ) {
        // copy directory
        if ( is_dir( $src ) ) {
            if ( $src != '.svn' ) {
                $dir = opendir( $src );
                @mkdir( $dst );
                while ( false !== ( $file = readdir( $dir )) ) {
                    if ( ( $file != '.' ) && ( $file != '..' ) ) {
                        if ( is_dir( $src . '/' . $file ) ) {
                            recurse_copy( $src . '/' . $file, $dst . '/' . $file, true );
                        } else {
                            if ( strpos( $file, '.DS_Store' ) === false ) {
                                copy( $src . '/' . $file, $dst . '/' . $file );
                            }
                        }
                    }
                }
                closedir( $dir );
            }
        } else {
            echo 'dir ' . $src . ' is not found!';
        }
    } else {
        if ( strpos( $src, '.DS_Store' ) === false ) {
            // copy file
            copy( $src, $dst );
        }
    }
}
  
// make file and directory array
function data_element( $src, $dst, $is_dir = false ) {
    $data = array();
    $data['src'] = $src;
    $data['dst'] = $dst;
    $data['isdir'] = $is_dir;
    return $data;
}

// make data

$data = array();

$src = '../app/addons/twigmo/schemas/api/payments/cardgate_ideal.php';
$dst = 'cardgate/app/addons/twigmo/schemas/api/payments/cardgate_ideal.php';
$is_dir = false;

array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/functions/smarty_plugins/function.cardgate_banken.php';
$dst = 'cardgate/app/functions/smarty_plugins/function.cardgate_banken.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/functions/smarty_plugins/function.cardgatestatus.php';
$dst = 'cardgate/app/functions/smarty_plugins/function.cardgatestatus.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../app/payments/cardgate';
$dst = 'cardgate/app/payments/cardgate';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../app/payments/cardgateafterpay.php';
$dst = 'cardgate/app/payments/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgateafterpay.php';
$dst = 'cardgate/app/payments/cardgateafterpay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatebancontact.php';
$dst = 'cardgate/app/payments/cardgatebancontact.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatebanktransfer.php';
$dst = 'cardgate/app/payments/cardgatebanktransfer.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatebitcoin.php';
$dst = 'cardgate/app/payments/cardgatebitcoin.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatecreditcard.php';
$dst = 'cardgate/app/payments/cardgatecreditcard.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatedirectdebit.php';
$dst = 'cardgate/app/payments/cardgatedirectdebit.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgategeneric.php';
$dst = 'cardgate/app/payments/cardgategeneric.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgategiropay.php';
$dst = 'cardgate/app/payments/cardgategiropay.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgateideal.php';
$dst = 'cardgate/app/payments/cardgateideal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgateklarna.php';
$dst = 'cardgate/app/payments/cardgateklarna.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatepaypal.php';
$dst = 'cardgate/app/payments/cardgatepaypal.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgateprzelewy24.php';
$dst = 'cardgate/app/payments/cardgateprzelewy24.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../app/payments/cardgatesofortbanking.php';
$dst = 'cardgate/app/payments/cardgatesofortbanking.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../design/backend/templates/views/orders/components/payments/cardgate_ideal.tpl';
$dst = 'cardgate/design/backend/templates/views/orders/components/payments/cardgate_ideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../design/backend/templates/views/payments/components/cc_processors/cardgateafterpay.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgateafterpay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatebancontact.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatebancontact.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatebanktransfer.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatebanktransfer.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatebitcoin.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatebitcoin.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatecreditcard.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatecreditcard.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatedirectdebit.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatedirectdebit.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgategeneric.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgategeneric.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgategiropay.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgategiropay.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgateideal.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgateideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgateklarna.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgateklarna.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatepaypal.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatepaypal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgateprzelewy24.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgateprzelewy24.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../design/backend/templates/views/payments/components/cc_processors/cardgatesofortbanking.tpl';
$dst = 'cardgate/design/backend/templates/views/payments/components/cc_processors/cardgatesofortbanking.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../design/themes/basic/templates/views/orders/components/payments/cardgate_ideal.tpl';
$dst = 'cardgate/design/themes/basic/templates/views/orders/components/payments/cardgate_ideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../design/themes/responsive/templates/views/orders/components/payments/cardgate_ideal.tpl';
$dst = 'cardgate/design/themes/responsive/templates/views/orders/components/payments/cardgate_ideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../images/cardgate';
$dst = 'cardgate/images/cardgate';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../var/themes_repository/basic/templates/views/orders/components/payments/cardgate_ideal.tpl';
$dst = 'cardgate/var/themes_repository/basic/templates/views/orders/components/payments/cardgate_ideal.tpl';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

$src = '../cardgate_install.php';
$dst = 'cardgate/cardgate_install.php';
$is_dir = false;
array_push( $data, data_element( $src, $dst, $is_dir ) );

foreach ( $data as $k => $v ) {
        recurse_copy( $v['src'], $v['dst'], $v['isdir'] );
}

// make the zip
echo 'files copied<br>';

// Get real path for our folder
$rootPath = '/home/richard/websites/cscart/htdocs/_plugin/cardgate';
$filename = 'cardgate.zip';

zipfiles($filename, $rootPath);
echo 'zipfile made<br>';
echo 'done!';
?>
