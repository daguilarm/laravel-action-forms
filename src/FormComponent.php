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
    protected function getModel(?string $model, ?string $id = null): ?object
    {
        if ($model) {
            $instance = match (true) {
                class_exists($model) => app($model),
                class_exists('\App\\'.$model) => app('\App\\'.$model),
                class_exists('\App\Models\\'.$model) => app('\App\Models\\'.$model),
                default => null,
            };

            return $id && $instance
                ? $instance::find($id)
                : $instance;
        }

        return null;
    }

    /**
     * Get the sections from the model if exists.
     */
    protected function getSection(?string $model): ?string
    {
        if ($model) {
            $_array = explode('\\', $model);
            $_array_text = $_array[count($_array) - 1];

            return str($_array_text)->lower()->plural()->toString();
        }

        return null;
    }

    protected function getKey(?string $model, ?string $id = null):string
    {
        $section = self::getSection($model);

        return $id ?? $section ?? md5(time());
    }
}
