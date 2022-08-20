<?php

namespace Ddxt\Support\Presenter;

trait PresentableTrait
{
    /**
     * Presentable trait
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Present data
     *
     * @return mixed
     */
    public function present()
    {
        if (! $this->presenter or ! class_exists($this->presenter)) {
            throw new \Exception('Please set the $presenter property to your presenter path.');
        }

        if (! $this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
