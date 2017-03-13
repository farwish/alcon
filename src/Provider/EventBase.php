<?php

namespace Alcon\Provider;

/**
 * Event Base for Observer.
 *
 * <code>
 *  class MyObserver implements \SplObserver {
 *      public function update(\SplSubject $sub) {
 *          // your logic.
 *      }
 *  }
 *
 *  $ev = new EventBase;
 *  $ob = new MyObserver;
 *  $ev->attach($ob);
 *  $ev->detach($ob);
 *  $ev->notify();
 * </code>
 *
 * @farwish
 */
class EventBase implements \SplSubject
{
    /**
     * Observer collection.
     *
     * @var \SplObjectStorage
     */
    private $os;

    public function __construct()
    {
        $this->os = new \SplObjectStorage();
    } 

    /**
     * attach.
     * 
     */
    public function attach(\SplObserver $ob)
    {
        $this->os->attach($ob);
    }

    /**
     * detach.
     *
     */
    public function detach(\SplObserver $ob)
    {
        if ($this->os->contains($ob)) {
            $this->os->detach($ob);
        }
    }

    /**
     * notify.
     *
     */
    public function notify()
    {
        foreach ($this->os as $observer) {
            $observer->update($this);
        }
    }
}
