<?php
namespace Zend\Queue\Adapter;
use Zend\Queue;
use Zend\Queue\Message;

class Mongo extends AbstractAdapter
{
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 27017;

    /**
     * @var resource
     */
    protected $_socket = null;

    /**
     * Constructor
     *
     * @param  array|\Zend\Config\Config $options
     * @param  null|\Zend\Queue\Queue $queue
     * @return void
     */
    public function __construct($options, Queue\Queue $queue = null)
    {
        if (!extension_loaded('mongo')) {
            throw new Queue\Exception('Mongo extension does not appear to be loaded');
        }

        parent::__construct($options, $queue);

        $options = &$this->_options['driverOptions'];

        if (!array_key_exists('host', $options)) {
            $options['host'] = self::DEFAULT_HOST;
        }
        if (!array_key_exists('port', $options)) {
            $options['port'] = self::DEFAULT_PORT;
        }
        if (!array_key_exists('dbname', $options)) {
            throw new \ArgumentErrorException('No option "dbname"');
        }

        $mongo = new \Mongo('mongodb://' . $options['host'] . ':' . (int)$options['port']);
        $this->_socket = $mongo->selectDB($options['dbname']);
    }

    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        if (is_resource($this->_socket)) {
            $this->_socket->close();
        }
    }


    /**
     * Retrieve queue instance
     *
     * @return \Zend\Queue\Queue
     */
    public function getQueue()
    {}

    /**
     * Set queue instnace
     *
     * @param  \Zend\Queue\Queue $queue
     * @return \Zend\Queue\Adapter
     */
    public function setQueue(Queue\Queue $queue)
    {}

    /**
     * Does a queue already exist?
     *
     * Use isSupported('isExists') to determine if an adapter can test for
     * queue existance.
     *
     * @param  string $name Queue name
     * @return boolean
     */
    public function isExists($name)
    {}

    /**
     * Create a new queue
     *
     * Visibility timeout is how long a message is left in the queue
     * "invisible" to other readers.  If the message is acknowleged (deleted)
     * before the timeout, then the message is deleted.  However, if the
     * timeout expires then the message will be made available to other queue
     * readers.
     *
     * @param  string  $name Queue name
     * @param  integer $timeout Default visibility timeout
     * @return boolean
     */
    public function create($name, $timeout=null)
    {

    }

    /**
     * Delete a queue and all of its messages
     *
     * Return false if the queue is not found, true if the queue exists.
     *
     * @param  string $name Queue name
     * @return boolean
     */
    public function delete($name)
    {}

    /**
     * Get an array of all available queues
     *
     * Not all adapters support getQueues(); use isSupported('getQueues')
     * to determine if the adapter supports this feature.
     *
     * @return array
     */
    public function getQueues()
    {
        return $this->_socket->listCollections();
    }

    /**
     * Return the approximate number of messages in the queue
     *
     * @param  \Zend\Queue\Queue|null $queue
     * @return integer
     */
    public function count(Queue\Queue $queue = null)
    {}

    /********************************************************************
     * Messsage management functions
     *********************************************************************/

    /**
     * Send a message to the queue
     *
     * @param  mixed $message Message to send to the active queue
     * @param  \Zend\Queue\Queue|null $queue
     * @return \Zend\Queue\Message
     */
    public function send($message, Queue\Queue $queue = null)
    {}

    /**
     * Get messages in the queue
     *
     * @param  integer|null $maxMessages Maximum number of messages to return
     * @param  integer|null $timeout Visibility timeout for these messages
     * @param  \Zend\Queue\Queue|null $queue
     * @return \Zend\Queue\Message\MessageIterator
     */
    public function receive($maxMessages = null, $timeout = null, Queue\Queue $queue = null)
    {}

    /**
     * Delete a message from the queue
     *
     * Return true if the message is deleted, false if the deletion is
     * unsuccessful.
     *
     * @param  \Zend\Queue\Message $message
     * @return boolean
     */
    public function deleteMessage(Message $message)
    {}

    /********************************************************************
     * Supporting functions
     *********************************************************************/

    /**
     * Returns the configuration options in this adapter.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Return a list of queue capabilities functions
     *
     * $array['function name'] = true or false
     * true is supported, false is not supported.
     *
     * @return array
     */
    public function getCapabilities()
    {}

    /**
     * Indicates if a function is supported or not.
     *
     * @param  string $name Function name
     * @return boolean
     */
    public function isSupported($name)
    {
        return true;
    }
}

