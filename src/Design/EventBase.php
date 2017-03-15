<?php

namespace Alcon\Design;

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
 *  $ob = new MyObserver; $ob2 = new MyObserver2;
 *  $ev->attach($ob); $ev->attach($ob2);
 *  $ev->detach($ob2);
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
     * @param \SplObserver $ob
     * 
     * @return void
     */
    public function attach(\SplObserver $ob)
    {
        $this->os->attach($ob);
    }

    /**
     * detach.
     *
     * @param \SplObserver $ob
     * 
     * @return void
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
     * @return void
     */
    public function notify()
    {
        foreach ($this->os as $observer) {
            $observer->update($this);
        }
    }
}
