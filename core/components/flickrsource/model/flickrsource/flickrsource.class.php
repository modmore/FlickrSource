<?php
require_once MODX_CORE_PATH . 'model/modx/sources/modmediasource.class.php';
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
class FlickrSource extends modMediaSource implements modMediaSourceInterface {
    public $config = array();
    public $endpoint = 'https://secure.flickr.com/';
    public $path = 'services/rest/';

    /**
     * @var modRestClient $client
     */
    public $client;


    public function __construct(xPDO &$xpdo) {
        parent::__construct($xpdo);
        $this->set('is_stream', false);
        $this->xpdo->lexicon->load('flickrsource:default');
    }

    /**
     * Initialize the source
     * @return boolean
     */
    public function initialize() {
        parent::initialize();

        return true;
    }

    public function api ($name, array $params = array(), $method = 'GET', array $options = array()) {
        if (!$this->getClient() || !$this->client->conn) {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, "Could not load rest.modRestClient for FlickrSource media source (request $name).");
            return false;
        }

        $params['api_key'] = $this->getProperty('api_key');
        $params['method'] = 'flickr.' . $name;
        $params['format'] = 'json';
        $params['nojsoncallback'] = 1;

        return $this->client->request($this->endpoint, $this->path, $method, $params, $options);
    }

    /**
     * Gets a single property from {@see: self::getPropertyList}
     *
     * @param $key
     * @param null $default
     * @param bool $checkEmpty
     *
     * @return null
     */
    public function getProperty($key, $default = null, $checkEmpty = true) {
        $properties = $this->getPropertyList();
        if (isset($properties[$key])) {
            if (($checkEmpty && !empty($properties[$key])) || !$checkEmpty) {
                return $properties[$key];
            }
        }
        return $default;
    }

    /**
     * Return an array of containers at this current level in the container structure. Used for the tree
     * navigation on the files tree.
     *
     * @param string $path
     *
     * @return array
     */
    public function getContainerList($path) {
        $pathSegments = explode('/', $path);

        switch (true) {
            case ($pathSegments[0] == 'photosets'):
                if (!isset($pathSegments[1]) || empty($pathSegments[1])) {
                    return $this->getPhotoSets($this->getProperty('user_id'));
                }

                if (!empty($pathSegments[1])) {
                    return $this->getPhotosInPhotoSet($pathSegments[1]);
                }

                break;

            case ($pathSegments[0] == 'galleries'):

                break;

            case ($pathSegments[0] == 'favorites'):
                break;

            default:
                $root = array();

                if ($this->getProperty('show_favorites', true, false)) {
                    $root[] = array(
                        'id' => 'favorites/',
                        'text' => $this->xpdo->lexicon('flickrsource.favorites'),
                        'cls' => 'flickr-favorites',
                        'type' => 'dir',
                        'leaf' => false,
                        'path' => 'favorites/',
                        'pathRelative' => 'favorites/',
                        'menu' => array(),
                    );
                }
                if ($this->getProperty('show_galleries', true, false)) {
                    $root[] = array(
                        'id' => 'galleries/',
                        'text' => $this->xpdo->lexicon('flickrsource.galleries'),
                        'cls' => 'flickr-galleries',
                        'type' => 'dir',
                        'leaf' => false,
                        'path' => 'galleries/',
                        'pathRelative' => 'galleries/',
                        'menu' => array(),
                    );
                }
                if ($this->getProperty('show_photosets', true, false)) {
                    $root[] = array(
                        'id' => 'photosets/',
                        'text' => $this->xpdo->lexicon('flickrsource.photosets'),
                        'cls' => 'gallery flickr-photosets',
                        'type' => 'dir',
                        'leaf' => false,
                        'path' => 'photosets/',
                        'pathRelative' => 'photosets/',
                        'menu' => array(),
                    );
                }
                return $root;
        }

        return array();
    }

    /**
     * Return a detailed list of objects in a specific path. Used for thumbnails in the Browser.
     *
     * @param string $path
     * @return array
     */
    public function getObjectsInContainer($path) {
        // TODO: Implement getObjectsInContainer() method.
    }

    /**
     * Create a container at the passed location with the passed name
     *
     * @param string $name
     * @param string $parentContainer
     * @return boolean
     */
    public function createContainer($name, $parentContainer) {
        // TODO: Implement createContainer() method.
    }

    /**
     * Remove the specified container
     *
     * @param string $path
     * @return boolean
     */
    public function removeContainer($path) {
        // TODO: Implement removeContainer() method.
    }

    /**
     * Rename a container
     *
     * @param string $oldPath
     * @param string $newName
     * @return boolean
     */
    public function renameContainer($oldPath, $newName) {
        // TODO: Implement renameContainer() method.
    }

    /**
     * Upload objects to a specific container
     *
     * @param string $container
     * @param array $objects
     * @return boolean
     */
    public function uploadObjectsToContainer($container, array $objects = array()) {
        // TODO: Implement uploadObjectsToContainer() method.
    }

    /**
     * Get the contents of an object
     *
     * @param string $objectPath
     * @return boolean
     */
    public function getObjectContents($objectPath) {
        // TODO: Implement getObjectContents() method.
    }

    /**
     * Update the contents of a specific object
     *
     * @param string $objectPath
     * @param string $content
     * @return boolean
     */
    public function updateObject($objectPath, $content) {
        // TODO: Implement updateObject() method.
    }

    /**
     * Create an object from a path
     *
     * @param string $objectPath
     * @param string $name
     * @param string $content
     * @return boolean|string
     */
    public function createObject($objectPath, $name, $content) {
        // TODO: Implement createObject() method.
    }

    /**
     * Remove an object
     *
     * @param string $objectPath
     * @return boolean
     */
    public function removeObject($objectPath) {
        // TODO: Implement removeObject() method.
    }

    /**
     * Rename a file/object
     *
     * @param string $oldPath
     * @param string $newName
     * @return bool
     */
    public function renameObject($oldPath, $newName) {
        // TODO: Implement renameObject() method.
    }

    /**
     * Get the openTo path for this source, used with TV input types and Static Elements/Resources
     *
     * @param string $value
     * @param array $parameters
     * @return string
     */
    public function getOpenTo($value, array $parameters = array()) {
        // TODO: Implement getOpenTo() method.
    }

    /**
     * Get the base path for this source. Only applicable to sources that are streams, used for determining
     * the base path with Static objects.
     *
     * @param string $object An optional file to find the base path with
     * @return string
     */
    public function getBasePath($object = '') {
        // TODO: Implement getBasePath() method.
    }

    /**
     * Get the base URL for this source. Only applicable to sources that are streams; used for determining the base
     * URL with Static objects and downloading objects.
     *
     * @param string $object
     * @return void
     */
    public function getBaseUrl($object = '') {
        // TODO: Implement getBaseUrl() method.
    }

    /**
     * Get the URL for an object in this source. Only applicable to sources that are streams; used for determining
     * the base URL with Static objects and downloading objects.
     *
     * @param string $object
     * @return void
     */
    public function getObjectUrl($object = '') {
        // TODO: Implement getObjectUrl() method.
    }

    /**
     * Move a file or folder to a specific location
     *
     * @param string $from The location to move from
     * @param string $to The location to move to
     * @param string $point The type of move; append, above, below
     * @return boolean
     */
    public function moveObject($from, $to, $point = 'append') {
        // TODO: Implement moveObject() method.
    }

    /**
     * Get the name of this source type, ie, "File System"
     * @return string
     */
    public function getTypeName() {
        return $this->xpdo->lexicon('flickrsource');
    }

    /**
     * Get a short description of this source type
     * @return string
     */
    public function getTypeDescription() {
        return $this->xpdo->lexicon('flickrsource.description');
    }

    /**
     * Get the default properties for this source. Override this in your custom source driver to provide custom
     * properties for your source type.
     * @return array
     */
    public function getDefaultProperties() {
        return array(
            'api_key' => array(
                'name' => 'api_key',
                'desc' => 'flickrsource.api_key.desc',
                'type' => 'textfield',
                'options' => '',
                'value' => '',
                'lexicon' => 'flickrsource:default',
            ),
            'api_secret' => array(
                'name' => 'api_secret',
                'desc' => 'flickrsource.api_secret.desc',
                'type' => 'textfield',
                'options' => '',
                'value' => '',
                'lexicon' => 'flickrsource:default',
            ),
            'user_id' => array(
                'name' => 'user_id',
                'desc' => 'flickrsource.user_id.desc',
                'type' => 'textfield',
                'options' => '',
                'value' => '',
                'lexicon' => 'flickrsource:default',
            ),
            'show_favorites' => array(
                'name' => 'show_favorites',
                'desc' => 'flickrsource.show_favorites.desc',
                'type' => 'combo-boolean',
                'options' => '',
                'value' => true,
                'lexicon' => 'flickrsource:default',
            ),
            'show_galleries' => array(
                'name' => 'show_galleries',
                'desc' => 'flickrsource.show_galleries.desc',
                'type' => 'combo-boolean',
                'options' => '',
                'value' => true,
                'lexicon' => 'flickrsource:default',
            ),
            'show_photosets' => array(
                'name' => 'show_photosets',
                'desc' => 'flickrsource.show_photosets.desc',
                'type' => 'combo-boolean',
                'options' => '',
                'value' => true,
                'lexicon' => 'flickrsource:default',
            ),

        );
    }

    private function getClient() {
        if (!$this->client) {
            $this->xpdo->loadClass('rest.modRestClient', '', false, true);
            $this->client = new modRestClient($this->xpdo);
            if ($this->client) {
                $this->client->getConnection();
                $this->client->setResponseType('json');
            }
        }
        return $this->client;
    }

    private function getPhotoUrl($id, $secret, $farm, $server) {
        return "http://farm{$farm}.staticflickr.com/{$server}/{$id}_{$secret}.jpg";
    }

    /**
     * @param $userId
     *
     * @return array
     */
    public function getPhotoSets($userId) {
        $response = $this->api('photosets.getList', array('user_id' => $userId));
        $data = $response->fromJSON();

        $sets = array();
        if (is_array($data) && $data['stat'] == 'ok') {
            foreach ($data['photosets']['photoset'] as $photoset) {
                $sets[] = array(
                    'id' => "photosets/{$photoset['id']}/",
                    'text' => $photoset['title']['_content'],
                    'qtip' => $photoset['description']['_content'],
                    'cls' => 'gallery flickr-photosets',
                    'type' => 'dir',
                    'leaf' => false,
                    'path' => "photosets/{$photoset['id']}/",
                    'pathRelative' => "photosets/{$photoset['id']}/",
                    'menu' => array(),
                );
            }
        } else {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Invalid response from flickr.photosets.getList:' . $response->response);
        }

        return $sets;
    }

    /**
     * @param $photoSet
     *
     * @return array
     */
    public function getPhotosInPhotoSet($photoSet) {
        $response = $this->api('photosets.getPhotos', array('photoset_id' => $photoSet));
        $data = $response->fromJSON();

        $photos = array();
        if (is_array($data) && $data['stat'] == 'ok') {
            foreach ($data['photoset']['photo'] as $photo) {
                $photoArray = array(
                    'id' => "photosets/{$data['photoset']['id']}/{$photo['id']}",
                    'text' => $photo['title'],
                    'cls' => '',
                    'type' => 'file',
                    'leaf' => true,
                    'qtip' => '<img src="' . $this->getPhotoUrl($photo['id'], $photo['secret'], $photo['farm'], $photo['server']) . '" alt="' . $photo['title'] . '" />',
                    'page' => null, // a page in the manager
                    //'perms' => $octalPerms,
                    'path' => "photosets/{$data['photoset']['id']}/{$photo['id']}",
                    'pathRelative' => "photosets/{$data['photoset']['id']}/{$photo['id']}",
                    'directory' => "photosets/{$data['photoset']['id']}/",
                    'url' => "photosets/{$data['photoset']['id']}/{$photo['id']}",
                    'urlAbsolute' => "photosets/{$data['photoset']['id']}/{$photo['id']}",
                    'file' => "photosets/{$data['photoset']['id']}/{$photo['id']}",
                    'menu' => array(),
                );

                $photos[] = $photoArray;
            }
        }

        return $photos;
    }
}
