<?php
/**
 * FlickrSource
 *
 * Copyright 2013 by Mark Hamstra, for modmore <support@modmore.com>
 *
 * This file is part of FlickrSource, a MODX Media Source implementation of the Flickr API,
 * developed by modmore and available from https://www.modmore.com/extras/flickrsource/
 *
 * Please see core/components/flickrsource/docs/license.txt file for license terms.
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

require_once dirname(dirname(__FILE__)) . '/config.core.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'core' => $root.'core/components/flickrsource/',
    'model' => $root.'core/components/flickrsource/model/',
    'schema' => $root.'core/components/flickrsource/model/schema/',
    'assets' => $root.'assets/components/flickrsource/',
);
$manager= $modx->getManager();
$generator= $manager->getGenerator();
$generator->classTemplate= <<<EOD
<?php
/**
 * FlickrSource
 *
 * Copyright 2013 by Mark Hamstra, for modmore <support@modmore.com>
 *
 * This file is part of FlickrSource, a MODX Media Source implementation of the Flickr API,
 * developed by modmore and available from https://www.modmore.com/extras/flickrsource/
 *
 * Please see core/components/flickrsource/docs/license.txt file for license terms.
 *
 * @package flickrsource
 */
class [+class+] extends [+extends+] {

}
EOD;

$generator->platformTemplate= <<<EOD
<?php
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\\\', '/') . '/[+class-lowercase+].class.php');
/**
 * FlickrSource
 *
 * Copyright 2013 by Mark Hamstra, for modmore <support@modmore.com>
 *
 * This file is part of FlickrSource, a MODX Media Source implementation of the Flickr API,
 * developed by modmore and available from https://www.modmore.com/extras/flickrsource/
 *
 * Please see core/components/flickrsource/docs/license.txt file for license terms.
 *
 * @package flickrsource
 * @subpackage [+platform+]
 */
class [+class+]_[+platform+] extends [+class+] {

}
EOD;

$generator->mapHeader= <<<EOD
<?php
/**
 * FlickrSource
 *
 * Copyright 2013 by Mark Hamstra, for modmore <support@modmore.com>
 *
 * This file is part of FlickrSource, a MODX Media Source implementation of the Flickr API,
 * developed by modmore and available from https://www.modmore.com/extras/flickrsource/
 *
 * Please see core/components/flickrsource/docs/license.txt file for license terms.
 *
 * @package flickrsource
 */

EOD;

$generator->parseSchema($sources['schema'].'flickrsource.mysql.schema.xml', $sources['model']);

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();
