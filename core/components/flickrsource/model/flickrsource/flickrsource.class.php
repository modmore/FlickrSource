<?php

require_once MODX_CORE_PATH . 'model/modx/sources/modmediasource.class.php';
/**
 * FlickrSource
 *
 * Provides a Media Source Driver for MODX Revolution that lets users interact with
 * Flickr galleries and photos from within MODX.
 *
 * @author Mark Hamstra @ modmore <mark@modmore.com>
 *
 * @extends modMediaSource
 * @implements modMediaSourceInterface
 */
class FlickrSource extends modMediaSource implements modMediaSourceInterface {
    public $config = array();

    /**
     * Initialize the source
     * @return boolean
     */
    public function initialize() {
        parent::initialize();

        return true;
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
        // TODO: Implement getContainerList() method.
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
        $this->xpdo->lexicon->load('flickrsource');
        return $this->xpdo->lexicon('flickrsource');
    }

    /**
     * Get a short description of this source type
     * @return string
     */
    public function getTypeDescription() {
        $this->xpdo->lexicon->load('flickrsource');
        return $this->xpdo->lexicon('flickrsource.description');
    }

    /**
     * Get the default properties for this source. Override this in your custom source driver to provide custom
     * properties for your source type.
     * @return array
     */
    public function getDefaultProperties() {
        // TODO: Implement getDefaultProperties() method.
    }
}
