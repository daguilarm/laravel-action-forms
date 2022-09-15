<?php

namespace Daguilarm\ActionForms\Components;

use Daguilarm\ActionForms\Configable;
use Daguilarm\ActionForms\FormComponent;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Search extends FormComponent
{
    use Configable;

    public Collection $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $label = null,
        public string $width = 'full',
        public ?string $dependOn = null,
        public string $dependOnType = 'disabled',
        public mixed $dependOnValue = null,
        public ?bool $conditional = null,
        public ?string $helper = null,
        public ?string $fromUrl = null,
        public array $fromArray = [],
        public ?string $requestId = null,
        public ?string $requestValue = null,
        public ?string $minChars = '2',
    ) {
        parent::__construct();

        $this->css = collect([
            'base' => $this->getConfigClasses($this->getThemeSearch()) . ' rounded-md',
            'icon_container' => config('action-forms.theme.search.icon_container'),
            'icon' => config('action-forms.theme.search.icon'),
            'result_container' => config('action-forms.theme.search.result_container'),
            'result' => config('action-forms.theme.search.result'),
            'label' => $this->getConfigClasses($this->getThemeLabel()),
            'error' => $this->getConfigClasses($this->getThemeErrorMessages()),
            'errorHighlight' => $this->getConfigClasses($this->getThemeErrorMessagesHighlight()),
            'helper' => $this->getConfigClasses($this->getThemeHelper()),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('action-forms::components.search');
    }
}
