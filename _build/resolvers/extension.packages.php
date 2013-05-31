<?php
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
	case xPDOTransport::ACTION_UPGRADE:
		/**
		 * @var modX $modx
		 */
		$modx = &$object->xpdo;
		$modelPath = $modx->getOption('flickrsource.core_path', null, $modx->getOption('core_path') . 'components/flickrsource/') . 'model/';
		if ($modx instanceof modX) {
			$modx->addExtensionPackage('flickrsource', $modelPath);
		}
		break;
	case xPDOTransport::ACTION_UNINSTALL:
		/**
		 * @var modX $modx
		 */
		$modx = &$object->xpdo;
		$modelPath = $modx->getOption('flickrsource.core_path', null, $modx->getOption('core_path') . 'components/flickrsource/') . 'model/';
		if ($modx instanceof modX) {
			$modx->removeExtensionPackage('flickrsource');
		}
		break;
}
return true;
