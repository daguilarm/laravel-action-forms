<?php

namespace Daguilarm\ActionForms;

use Illuminate\View\Component;

abstract class FormComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    abstract public function render();

    /**
     * Get the model if exists.
     */
    protected function getModel(?string $model): ?object 
    {
        if($model) {
            if (class_exists($model)) {
                return app($model);
            }

            if (class_exists('\App\\' . $model)) {
                return app('\App\\' . $model);
            }

            if (class_exists('\App\Models\\' . $model)) {
                return app('\App\Models\\' . $model);
            }
        }

        return null;
    }

    /**
     * Get the sections from the model if exists.
     */
    protected function getSection(?string $model): ?string
    {
        if($model) {
            $_array = explode('\\', $model);
            $_array_text = $_array[count($_array)-1];

            return str($_array_text)->lower()->plural()->toString();
        }

        return null;
    }
}
