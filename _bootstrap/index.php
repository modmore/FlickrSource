<?php
/* Get the core config */
if (!file_exists(dirname(dirname(__FILE__)).'/config.core.php')) {
    die('ERROR: missing '.dirname(dirname(__FILE__)).'/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once dirname(dirname(__FILE__)).'/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error','error.modError', '', '');

$componentPath = dirname(dirname(__FILE__));

$FlickrSource = $modx->getService('flickrsource','FlickrSource', $componentPath.'/core/components/flickrsource/model/flickrsource/', array(
    'flickrsource.core_path' => $componentPath.'/core/components/flickrsource/',
));

/* Namespace */
if (!createObject('modNamespace',array(
    'name' => 'flickrsource',
    'path' => $componentPath.'/core/components/flickrsource/',
    'assets_path' => $componentPath.'/assets/components/flickrsource/',
),'name', false)) {
    echo "Error creating namespace flickrsource.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', array(
    'key' => 'flickrsource.core_path',
    'value' => $componentPath.'/core/components/flickrsource/',
    'xtype' => 'textfield',
    'namespace' => 'flickrsource',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating flickrsource.core_path setting.\n";
}

$manager = $modx->getManager();


/* Create the tables */
$objectContainers = array();
echo "Creating tables...\n";
foreach ($objectContainers as $oC) {
    $manager->createObjectContainer($oC);
}

$level = $modx->setLogLevel(xPDO::LOG_LEVEL_FATAL);
// Database upgrades here..
$modx->setLogLevel($level);


/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject ($className = '', array $data = array(), $primaryField = '', $update = true) {
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        $object = $modx->getObject($className, array($primaryField => $data[$primaryField]));
        if ($object instanceof $className) {
            if ($update) {
                $object->fromArray($data);
                return $object->save();
            } else {
                echo "Skipping {$className} {$data[$primaryField]}: already exists.\n";
                return true;
            }
        }
    }

    /* Create new object if it doesn't exist */
    if (!$object) {
        $object = $modx->newObject($className);
        $object->fromArray($data, '', true);
        return $object->save();
    }

    return false;
}
